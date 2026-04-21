<?php
declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

const LAGO_THEME_VERSION = '1.0.0';

add_action('after_setup_theme', function (): void {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', ['search-form', 'comment-form', 'gallery', 'caption', 'style', 'script']);
	add_theme_support('custom-logo', ['height' => 80, 'width' => 240, 'flex-width' => true]);

	register_nav_menus([
		'primary' => __('Primary Menu', 'lago-process'),
	]);
});

add_action('wp_enqueue_scripts', function (): void {
	wp_enqueue_style(
		'lago-process-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Manrope:wght@400;500;600;700;800&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'lago-process-screen',
		get_theme_file_uri('assets/css/screen.css'),
		[],
		LAGO_THEME_VERSION
	);
});

function lago_project_post_types(): array {
	return function_exists('lp_project_types') ? lp_project_types() : [];
}

function lago_project_query_args(int $posts_per_page = 10): array {
	return [
		'post_type'      => array_keys(lago_project_post_types()),
		'post_status'    => 'publish',
		'posts_per_page' => $posts_per_page,
		'orderby'        => 'menu_order date',
		'order'          => 'DESC',
		'no_found_rows'  => true,
	];
}

function lago_brand_query_args(int $posts_per_page = 12): array {
	return [
		'post_type'      => 'lp_brand',
		'post_status'    => 'publish',
		'posts_per_page' => $posts_per_page,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	];
}

function lago_field(string $key, ?int $post_id = null): string {
	if (function_exists('lp_get_field')) {
		return (string) lp_get_field($key, $post_id);
	}

	return '';
}

function lago_field_lines(string $key, ?int $post_id = null): array {
	$value = lago_field($key, $post_id);
	$lines = preg_split('/\r\n|\r|\n/', $value) ?: [];

	return array_values(array_filter(array_map('trim', $lines)));
}

function lago_home_field(string $key, string $fallback = ''): string {
	$page_id = (int) get_option('page_on_front');
	if ($page_id <= 0 && is_page()) {
		$page_id = (int) get_the_ID();
	}

	$value = $page_id > 0 ? (string) get_post_meta($page_id, $key, true) : '';
	return $value !== '' ? $value : $fallback;
}

function lago_decode_json_blocks(string $json, array $fallback = []): array {
	if ($json === '') {
		return $fallback;
	}

	$decoded = json_decode($json, true);
	return is_array($decoded) ? $decoded : $fallback;
}

function lago_project_type_label(?string $post_type = null): string {
	$post_type = $post_type ?: get_post_type();
	$config = lago_project_post_types()[$post_type] ?? null;
	return is_array($config) ? (string) $config['singular'] : (string) $post_type;
}

function lago_project_accent(?string $post_type = null): string {
	$post_type = $post_type ?: get_post_type();
	$config = lago_project_post_types()[$post_type] ?? null;
	return is_array($config) ? (string) $config['accent'] : '#111827';
}

function lago_project_visual_uri(?string $post_type = null): string {
	$post_type = $post_type ?: get_post_type();
	$images = [
		'lp_delivery'  => 'project-delivery.svg',
		'lp_app'       => 'project-app.svg',
		'lp_pms'       => 'project-pms.svg',
		'lp_crm'       => 'project-crm.svg',
		'lp_fusion_ai' => 'project-ai.svg',
	];

	return get_theme_file_uri('assets/img/' . ($images[$post_type] ?? 'project-app.svg'));
}

function lago_render_flexible_sections(?int $post_id = null): void {
	$sections = function_exists('lp_get_flexible_sections') ? lp_get_flexible_sections($post_id) : [];
	if (!$sections) {
		return;
	}

	foreach ($sections as $section) {
		if (!is_array($section)) {
			continue;
		}

		$layout = (string) ($section['layout'] ?? '');
		if ($layout === 'hero') {
			?>
			<section class="flex-section flex-hero">
				<p class="eyebrow"><?php echo esc_html((string) ($section['eyebrow'] ?? 'Flexible content')); ?></p>
				<h2><?php echo esc_html((string) ($section['headline'] ?? 'Structured section')); ?></h2>
				<p><?php echo esc_html((string) ($section['body'] ?? '')); ?></p>
			</section>
			<?php
		}

		if ($layout === 'metric_grid' && !empty($section['items']) && is_array($section['items'])) {
			?>
			<section class="metric-grid">
				<?php foreach ($section['items'] as $item) :
					if (!is_array($item)) {
						continue;
					}
					?>
					<div>
						<strong><?php echo esc_html((string) ($item['value'] ?? '')); ?></strong>
						<span><?php echo esc_html((string) ($item['label'] ?? '')); ?></span>
					</div>
				<?php endforeach; ?>
			</section>
			<?php
		}
	}
}
