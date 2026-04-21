<?php
/**
 * Plugin Name: Lago Runtime Optimization
 * Description: Conservative runtime optimization, delayed trackers, image attributes, and XML sitemap for Lago Process.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

function lago_runtime_should_run(): bool {
	return !is_admin();
}

function lago_runtime_is_home(): bool {
	$request_uri  = (string) ($_SERVER['REQUEST_URI'] ?? '');
	$request_path = trim((string) wp_parse_url($request_uri, PHP_URL_PATH), '/');

	return is_front_page() || is_home() || $request_path === '';
}

function lago_runtime_is_delayed_tracker(string $src): bool {
	return (
		strpos($src, 'googletagmanager.com') !== false ||
		strpos($src, 'google-analytics.com') !== false ||
		strpos($src, 'connect.facebook.net') !== false ||
		strpos($src, 'facebook.com/tr') !== false ||
		strpos($src, 'linkedin.com/insight') !== false
	);
}

function lago_runtime_get_image_dimensions(string $src): ?array {
	static $cache = [];

	if (array_key_exists($src, $cache)) {
		return $cache[$src];
	}

	$uploads = wp_get_upload_dir();
	$base_url = (string) ($uploads['baseurl'] ?? '');
	$base_dir = (string) ($uploads['basedir'] ?? '');

	if ($base_url !== '' && $base_dir !== '' && strpos($src, $base_url) === 0) {
		$relative = ltrim(substr($src, strlen($base_url)), '/');
		$file = wp_normalize_path(trailingslashit($base_dir) . $relative);
		if (is_file($file)) {
			$size = @getimagesize($file);
			if (is_array($size) && !empty($size[0]) && !empty($size[1])) {
				$cache[$src] = [(int) $size[0], (int) $size[1]];
				return $cache[$src];
			}
		}
	}

	if (preg_match('#-(\d{2,5})x(\d{2,5})\.(?:jpe?g|png|webp|avif)(?:\?|$)#i', $src, $matches)) {
		$cache[$src] = [(int) $matches[1], (int) $matches[2]];
		return $cache[$src];
	}

	$cache[$src] = null;
	return null;
}

function lago_runtime_add_missing_dimensions(string $html): string {
	if ($html === '' || stripos($html, '<img') === false) {
		return $html;
	}

	$updated = preg_replace_callback('#<img\b([^>]*)>#i', static function (array $matches): string {
		$attrs = (string) ($matches[1] ?? '');

		if (preg_match('#\swidth=(["\']).*?\1#i', $attrs) && preg_match('#\sheight=(["\']).*?\1#i', $attrs)) {
			return $matches[0];
		}

		if (!preg_match('#\ssrc=(["\'])([^"\']+)\1#i', $attrs, $src_match)) {
			return $matches[0];
		}

		$dimensions = lago_runtime_get_image_dimensions((string) $src_match[2]);
		if (!is_array($dimensions)) {
			return $matches[0];
		}

		if (!preg_match('#\swidth=(["\']).*?\1#i', $attrs)) {
			$attrs .= ' width="' . (int) $dimensions[0] . '"';
		}

		if (!preg_match('#\sheight=(["\']).*?\1#i', $attrs)) {
			$attrs .= ' height="' . (int) $dimensions[1] . '"';
		}

		return '<img' . $attrs . '>';
	}, $html);

	return is_string($updated) ? $updated : $html;
}

add_action('init', function (): void {
	if (!lago_runtime_should_run()) {
		return;
	}

	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10);
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
	remove_action('wp_head', 'wp_oembed_add_host_js');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

	add_rewrite_rule('^sitemap\.xml$', 'index.php?lago_sitemap=1', 'top');
}, 20);

add_action('wp_enqueue_scripts', function (): void {
	if (!lago_runtime_is_home()) {
		return;
	}

	foreach (['wp-block-library', 'wp-block-library-theme', 'global-styles', 'classic-theme-styles'] as $handle) {
		wp_dequeue_style($handle);
		wp_deregister_style($handle);
	}

	if (!is_user_logged_in()) {
		wp_dequeue_style('dashicons');
		wp_deregister_style('dashicons');
	}
}, 1000);

add_filter('script_loader_tag', function (string $tag, string $handle, string $src): string {
	if (!lago_runtime_should_run()) {
		return $tag;
	}

	if ($src !== '' && lago_runtime_is_delayed_tracker($src)) {
		return "<script type='text/plain' data-lago-delay='1' data-lago-delay-src='" . esc_url($src) . "'></script>";
	}

	if (strpos($tag, ' defer') === false && !in_array($handle, ['jquery', 'jquery-core'], true)) {
		return str_replace(' src', ' defer src', $tag);
	}

	return $tag;
}, 10, 3);

add_filter('style_loader_tag', function (string $html, string $handle, string $href): string {
	if (!lago_runtime_is_home() || $href === '') {
		return $html;
	}

	$async_styles = ['wp-block-library', 'global-styles'];
	if (!in_array($handle, $async_styles, true)) {
		return $html;
	}

	return '<link rel="stylesheet" id="' . esc_attr($handle) . '-css" href="' . esc_url($href) . '" media="print" onload="this.media=\'all\'">'
		. '<noscript><link rel="stylesheet" href="' . esc_url($href) . '" media="all"></noscript>';
}, 10, 3);

add_filter('the_content', static fn(string $content): string => lago_runtime_add_missing_dimensions($content), 20);

add_filter('wp_get_attachment_image_attributes', function (array $attr): array {
	if (is_admin() || !lago_runtime_should_run()) {
		return $attr;
	}

	if (empty($attr['loading'])) {
		$attr['loading'] = 'lazy';
	}
	$attr['decoding'] = 'async';

	return $attr;
}, 20);

add_action('wp_head', function (): void {
	if (!lago_runtime_is_home()) {
		return;
	}
	?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="dns-prefetch" href="https://www.googletagmanager.com">
	<style id="lago-runtime-css">
		.skip-link:focus{position:fixed;left:12px;top:12px;z-index:100000;padding:12px 16px;background:#fff;color:#111;border:2px solid #111}
	</style>
	<?php
}, 1);

add_action('template_redirect', function (): void {
	if (!lago_runtime_should_run()) {
		return;
	}

	ob_start(static function (string $html): string {
		$html = lago_runtime_add_missing_dimensions($html);
		if (stripos($html, 'role="main"') === false) {
			$html = preg_replace('#<main\b#i', '<main role="main"', $html, 1) ?: $html;
		}
		return $html;
	});
}, 0);

add_action('wp_footer', function (): void {
	if (!lago_runtime_should_run()) {
		return;
	}
	?>
	<script id="lago-runtime-trackers">
	(function(){
		var booted=false;
		function loadDelayedTrackers(){
			if(booted) return;
			booted=true;
			document.querySelectorAll('script[data-lago-delay="1"][data-lago-delay-src]').forEach(function(node){
				var src=node.getAttribute('data-lago-delay-src') || '';
				if(!src || document.querySelector('script[src="'+src+'"]')) return;
				var s=document.createElement('script');
				s.src=src;
				s.async=true;
				(document.head || document.body || document.documentElement).appendChild(s);
			});
		}
		['touchstart','scroll','click','mousemove','keydown'].forEach(function(ev){
			window.addEventListener(ev, loadDelayedTrackers, {once:true, passive:true});
		});
		window.addEventListener('load', function(){ setTimeout(loadDelayedTrackers, 800); }, {once:true});
		setTimeout(loadDelayedTrackers, 3200);
	})();
	</script>
	<?php
}, 999);

add_filter('pre_http_request', function ($pre, array $args, string $url) {
	$blocked_hosts = ['api.rometheme.pro'];
	foreach ($blocked_hosts as $host) {
		if (strpos($url, $host) !== false) {
			return [
				'headers'  => [],
				'body'     => '{}',
				'response' => ['code' => 200, 'message' => 'OK'],
				'cookies'  => [],
				'filename' => null,
			];
		}
	}

	return $pre;
}, 10, 3);

add_filter('query_vars', function (array $vars): array {
	$vars[] = 'lago_sitemap';
	return $vars;
});

add_action('template_redirect', function (): void {
	if (!get_query_var('lago_sitemap')) {
		return;
	}

	header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	$urls = [home_url('/')];
	$query = new WP_Query([
		'post_type'      => array_merge(['page', 'post'], array_keys(function_exists('lp_project_types') ? lp_project_types() : [])),
		'post_status'    => 'publish',
		'posts_per_page' => 200,
		'fields'         => 'ids',
		'no_found_rows'  => true,
	]);

	foreach ($query->posts as $post_id) {
		$urls[] = get_permalink((int) $post_id);
	}

	foreach (array_unique(array_filter($urls)) as $url) {
		if (strpos((string) $url, '?') !== false) {
			continue;
		}
		echo "\t<url><loc>" . esc_url($url) . "</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>\n";
	}

	echo '</urlset>';
	exit;
}, 5);
