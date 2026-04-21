<?php
declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

const LAGO_THEME_VERSION = '1.1.1';

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
		'lago-process-screen',
		get_theme_file_uri('assets/css/screen.css'),
		[],
		LAGO_THEME_VERSION
	);

	wp_enqueue_script(
		'lago-process-navigation',
		get_theme_file_uri('assets/js/navigation.js'),
		[],
		LAGO_THEME_VERSION,
		true
	);
});

add_filter('style_loader_tag', function (string $html, string $handle, string $href): string {
	if ($handle !== 'lago-process-screen' || is_admin() || $href === '') {
		return $html;
	}

	return '<link rel="preload" as="style" id="' . esc_attr($handle) . '-css-preload" href="' . esc_url($href) . '" onload="this.onload=null;this.rel=\'stylesheet\'">'
		. '<noscript><link rel="stylesheet" id="' . esc_attr($handle) . '-css" href="' . esc_url($href) . '"></noscript>';
}, 10, 3);

remove_action('wp_head', 'rel_canonical');

function lago_seo_description(): string {
	if (is_singular()) {
		$excerpt = trim(wp_strip_all_tags((string) get_the_excerpt()));
		if ($excerpt !== '') {
			return $excerpt;
		}
	}

	return 'Lucas Bacellar portfolio and showcase for custom WordPress development, marketing systems, hospitality platforms, integrations, Docker versioning and automation workflows.';
}

function lago_canonical_url(): string {
	if (is_singular()) {
		return (string) get_permalink();
	}

	return home_url(add_query_arg([], (string) wp_parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH)));
}

add_filter('wp_robots', function (array $robots): array {
	$robots['index'] = true;
	$robots['follow'] = true;
	$robots['max-image-preview'] = 'large';
	$robots['max-snippet'] = -1;
	$robots['max-video-preview'] = -1;

	return $robots;
});

add_filter('robots_txt', function (string $output): string {
	return "User-agent: *\nAllow: /\nSitemap: " . home_url('/sitemap.xml') . "\n";
}, 10, 1);

add_action('wp_head', function (): void {
	$title = wp_get_document_title();
	$description = lago_seo_description();
	$canonical = lago_canonical_url();
	$image = get_theme_file_uri('assets/img/hero-showcase.webp');
	?>
	<link rel="preload" as="image" href="<?php echo esc_url($image); ?>" imagesrcset="<?php echo esc_url($image); ?> 1536w" imagesizes="(max-width: 920px) 100vw, 61vw" fetchpriority="high">
	<meta name="description" content="<?php echo esc_attr($description); ?>">
	<link rel="canonical" href="<?php echo esc_url($canonical); ?>">
	<meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
	<meta property="og:title" content="<?php echo esc_attr($title); ?>">
	<meta property="og:description" content="<?php echo esc_attr($description); ?>">
	<meta property="og:url" content="<?php echo esc_url($canonical); ?>">
	<meta property="og:image" content="<?php echo esc_url($image); ?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr($description); ?>">
	<meta name="twitter:image" content="<?php echo esc_url($image); ?>">
	<script type="application/ld+json"><?php echo wp_json_encode([
		'@context' => 'https://schema.org',
		'@type' => 'Person',
		'name' => 'Lucas Bacellar',
		'url' => home_url('/'),
		'jobTitle' => 'WordPress Developer',
		'knowsAbout' => ['WordPress', 'Elementor Pro', 'ACF', 'Zapier', 'CRM integrations', 'OpenAI workflows', 'Hospitality systems'],
	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
	<?php
}, 1);

add_action('wp_head', function (): void {
	if (!is_front_page() && !is_home()) {
		return;
	}
	?>
	<style id="lago-critical-css">
		:root{--bg:#f4f4f2;--surface:#fff;--ink:#171717;--muted:#6d6d6a;--line:#d7d7d3;--charcoal:#2b2b2b}
		*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--ink);font-family:Aptos,"Segoe UI",sans-serif;line-height:1.65}a{color:inherit}.site-main,.site-footer{width:min(1180px,calc(100% - 40px));margin:0 auto}.site-header{width:100%;border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:rgba(244,244,242,.92)}.site-header-inner{display:flex;align-items:center;justify-content:space-between;gap:28px;width:100%;padding:18px 24px}.brand{display:flex;align-items:center;gap:14px;text-decoration:none}.brand-mark{display:grid;place-items:center;width:44px;height:44px;border-radius:50%;background:var(--charcoal);color:#fff;font-size:13px;font-weight:800}.brand strong,.brand em{display:block}.brand em{color:var(--muted);font-size:12px;font-style:normal}.main-nav{display:flex;align-items:center;gap:18px}.main-nav ul{display:flex;align-items:center;gap:8px;margin:0;padding:0;list-style:none}.main-nav a,.nav-cta,.button{display:inline-flex;align-items:center;text-decoration:none}.main-nav a{border-radius:999px;padding:10px 12px;color:var(--muted);font-size:12px;font-weight:800;letter-spacing:.09em;text-transform:uppercase}.nav-cta,.button{justify-content:center;border:1px solid var(--ink);border-radius:999px;padding:11px 18px;font-size:13px;font-weight:800}.nav-cta,.button.primary{background:var(--ink);color:#fff!important}.hero-section{display:grid;grid-template-columns:minmax(340px,.78fr) minmax(0,1.22fr);gap:0;width:100vw;margin-left:calc(50% - 50vw);border-bottom:1px solid var(--line)}.hero-copy{display:flex;flex-direction:column;justify-content:center;padding:clamp(34px,5vw,72px)}.eyebrow{margin:0 0 14px;color:var(--muted);font-size:11px;font-weight:800;letter-spacing:.18em;text-transform:uppercase}h1,h2,h3{margin:0;color:var(--ink);font-family:Georgia,"Times New Roman",serif;font-weight:600;line-height:.98;letter-spacing:-.035em}.hero-copy h1{max-width:590px;font-size:clamp(30px,3.4vw,46px);line-height:1.04}.hero-lede{max-width:720px;margin:24px 0 0;color:var(--muted);font-size:clamp(17px,1.8vw,22px)}.hero-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:30px}.hero-panel{overflow:hidden;background:var(--surface)}.hero-banner{position:relative;display:flex;align-items:end;min-height:520px;overflow:hidden;background:#1f1f1f}.hero-banner img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;filter:grayscale(70%) contrast(1.04)}.hero-banner:before{content:"";position:absolute;inset:0;background:linear-gradient(0deg,rgba(20,20,20,.48),rgba(20,20,20,0) 52%)}.hero-banner>div{position:relative;z-index:1;width:min(420px,calc(100% - 44px));margin:28px;border-radius:18px;padding:22px;background:rgba(255,255,255,.92)}@media(max-width:920px){.main-nav{display:none}.site-header.is-menu-open .main-nav{display:grid}.hero-section{display:block}.hero-banner{min-height:360px}}
	</style>
	<?php
}, 2);

add_filter('wp_speculation_rules_configuration', '__return_null');

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
