<?php
/**
 * Plugin Name: Lago Page Cache
 * Description: Lightweight full-page cache for anonymous visitors with safe WordPress bypass rules.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

const LAGO_PAGE_CACHE_TTL = 1800;

// Store cached HTML outside theme/plugin folders so deployments stay clean.
function lago_page_cache_dir(): string {
	return WP_CONTENT_DIR . '/cache/lago-page-cache';
}

// Bypass cache for unsafe requests, authenticated sessions and dynamic WordPress contexts.
function lago_page_cache_should_bypass(): bool {
	if (is_admin() || wp_doing_ajax() || wp_is_json_request()) {
		return true;
	}

	if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
		return true;
	}

	if (!empty($_GET)) {
		return true;
	}

	if (is_user_logged_in() || is_feed() || is_search() || is_404()) {
		return true;
	}

	$request_uri = (string) ($_SERVER['REQUEST_URI'] ?? '');
	if ($request_uri === '' || str_contains($request_uri, '/wp-admin') || str_contains($request_uri, '/wp-login.php')) {
		return true;
	}

	foreach ($_COOKIE as $name => $value) {
		if (str_starts_with((string) $name, 'wordpress_logged_in_') || str_starts_with((string) $name, 'wp-postpass_')) {
			return true;
		}
	}

	return false;
}

// Build a stable cache key from host and URI so each public URL gets its own file.
function lago_page_cache_key(): string {
	$host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? 'site'));
	$uri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
	$theme_version = defined('LAGO_THEME_VERSION') ? (string) LAGO_THEME_VERSION : '1';
	return hash('sha256', $theme_version . '|' . $host . '|' . $uri) . '.html';
}

// Resolve the full cache file path for the current request.
function lago_page_cache_file(): string {
	return trailingslashit(lago_page_cache_dir()) . lago_page_cache_key();
}

// Send a simple response header for debugging HIT, MISS and BYPASS behavior.
function lago_page_cache_send_headers(string $status): void {
	if (headers_sent()) {
		return;
	}

	header('X-Lago-Cache: ' . $status);
	header('Cache-Control: public, max-age=300, stale-while-revalidate=1800');
}

// Serve a valid cached page before WordPress renders the template.
function lago_page_cache_try_serve(): void {
	if (lago_page_cache_should_bypass()) {
		lago_page_cache_send_headers('BYPASS');
		return;
	}

	$file = lago_page_cache_file();
	if (!is_file($file) || filemtime($file) < (time() - LAGO_PAGE_CACHE_TTL)) {
		lago_page_cache_send_headers('MISS');
		return;
	}

	lago_page_cache_send_headers('HIT');
	readfile($file);
	exit;
}

// Persist anonymous HTML responses atomically after WordPress finishes rendering.
function lago_page_cache_store(string $html): string {
	if (lago_page_cache_should_bypass() || $html === '' || http_response_code() >= 400) {
		return $html;
	}

	if (!is_dir(lago_page_cache_dir())) {
		wp_mkdir_p(lago_page_cache_dir());
	}

	$file = lago_page_cache_file();
	$tmp = $file . '.' . getmypid() . '.tmp';
	file_put_contents($tmp, $html, LOCK_EX);
	rename($tmp, $file);

	return $html;
}

// Clear cached HTML when content or theme state changes.
function lago_page_cache_flush(): void {
	$dir = lago_page_cache_dir();
	if (!is_dir($dir)) {
		return;
	}

	$files = glob(trailingslashit($dir) . '*.html');
	if (!is_array($files)) {
		return;
	}

	foreach ($files as $file) {
		if (is_file($file)) {
			@unlink($file);
		}
	}
}

// Run the cache before normal template rendering and capture the generated HTML on misses.
add_action('template_redirect', function (): void {
	lago_page_cache_try_serve();
	ob_start('lago_page_cache_store');
}, -1000);

// Invalidate the cache on common content lifecycle events.
foreach (['save_post', 'deleted_post', 'trashed_post', 'clean_post_cache', 'switch_theme'] as $hook) {
	add_action($hook, 'lago_page_cache_flush');
}
