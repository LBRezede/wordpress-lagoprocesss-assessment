<?php
declare(strict_types=1);

get_header();
$project_query = new WP_Query(lago_project_query_args(12));
$brand_query = new WP_Query(lago_brand_query_args(12));
$proof_blocks = lago_decode_json_blocks(lago_home_field('lp_home_proof_blocks'), [
	['title' => 'Classic Editor', 'body' => 'Gutenberg is disabled by code. Pages and CPTs open in the classic WordPress editor.'],
	['title' => 'Theme-owned layout', 'body' => 'Hero, proof blocks, brands, cards, documentation and singles are rendered by PHP theme templates.'],
	['title' => 'ACF-like fields', 'body' => 'Stack, APIs, temporary credentials, evidence and flexible sections are editable post meta.'],
	['title' => 'Real CPTs', 'body' => 'Delivery, App, PMS, CRM, Fusion AI and Served Brands are managed in the Lago Portfolio admin area.'],
]);
$architecture_blocks = lago_decode_json_blocks(lago_home_field('lp_home_architecture_blocks'), [
	['number' => '01', 'title' => 'Structured CPTs', 'body' => 'Delivery, App, PMS, CRM and Fusion AI are separate post types with dashboard icons, archives and REST fields.'],
	['number' => '02', 'title' => 'ACF-style fields', 'body' => 'Stack, APIs, automations, code evidence and flexible sections are stored as post meta and rendered by theme helpers.'],
	['number' => '03', 'title' => 'Runtime hardening', 'body' => 'The mu-plugin removes WordPress noise, delays trackers, adds image attributes and serves a lightweight sitemap.'],
]);
$highlight_blocks = lago_decode_json_blocks(lago_home_field('lp_home_highlights_blocks'), [
	['title' => 'Custom WordPress with real structure', 'body' => 'custom themes, CPTs, ACF-like fields, admin menus and code-controlled rendering.'],
	['title' => 'Flexible content without page-builder dependency', 'body' => 'reusable sections, editable admin content and theme-owned layout consistency.'],
	['title' => 'Integrations that connect marketing and operations', 'body' => 'Booking/OTA, CRM, webhooks, ad tracking, OpenAI, Google Calendar, email and internal workflows.'],
	['title' => 'Production-minded delivery', 'body' => 'documentation, conservative deployment, runtime optimization, SSL, Nginx, databases, caching and post-launch maintenance.'],
]);
?>
<section class="hero-section">
	<div class="hero-copy">
		<p class="eyebrow"><?php echo esc_html(lago_home_field('lp_home_hero_eyebrow', 'Lucas Bacellar Portfolio')); ?></p>
		<h1><?php echo esc_html(lago_home_field('lp_home_hero_title', 'WordPress developer for marketing systems, integrations and hospitality platforms.')); ?></h1>
		<p class="hero-lede"><?php echo esc_html(lago_home_field('lp_home_hero_lede', 'A theme-driven portfolio with separate project pages, classic WordPress editing, custom post types, ACF-like fields, cache, documentation and real server evidence.')); ?></p>
		<div class="hero-actions">
			<a class="button primary" href="<?php echo esc_url(lago_home_field('lp_home_primary_url', home_url('/projects/'))); ?>"><?php echo esc_html(lago_home_field('lp_home_primary_label', 'View Projects')); ?></a>
			<a class="button ghost" href="<?php echo esc_url(lago_home_field('lp_home_secondary_url', home_url('/documentation/'))); ?>"><?php echo esc_html(lago_home_field('lp_home_secondary_label', 'Documentation')); ?></a>
		</div>
	</div>
	<div class="hero-panel">
		<div class="hero-banner hero-photo" aria-label="Portfolio systems banner">
			<img src="<?php echo esc_url(get_theme_file_uri('assets/img/hero-showcase.webp')); ?>" alt="Premium workspace representing WordPress, Elementor Pro and hospitality marketing systems">
			<div>
				<span><?php echo esc_html(lago_home_field('lp_home_banner_label', 'Featured build')); ?></span>
				<strong><?php echo esc_html(lago_home_field('lp_home_banner_title', 'Custom WordPress + integrations portfolio')); ?></strong>
				<p><?php echo esc_html(lago_home_field('lp_home_banner_body', 'Separate pages for projects, documentation, proof and served brands.')); ?></p>
				<em><?php echo esc_html(lago_home_field('lp_home_banner_badge', 'Hospitality brand websites built with WordPress + Elementor Pro')); ?></em>
			</div>
		</div>
		<div class="stat-strip">
			<strong>5</strong><span>Custom post types</span>
			<strong>10+</strong><span>Editable project fields</span>
			<strong>2</strong><span>MU performance/cache plugins</span>
		</div>
	</div>
</section>

<section id="proofs" class="proof-section">
	<div class="section-heading">
		<p class="eyebrow">Proof Highlights</p>
		<h2><?php echo esc_html(lago_home_field('lp_home_proof_title', 'What this portfolio proves at a technical level.')); ?></h2>
	</div>
	<div class="proof-grid">
		<?php foreach ($proof_blocks as $block) : ?>
			<?php if (!is_array($block)) { continue; } ?>
			<article>
				<strong><?php echo esc_html((string) ($block['title'] ?? 'Proof')); ?></strong>
				<p><?php echo esc_html((string) ($block['body'] ?? '')); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<section id="architecture" class="architecture-section">
	<div>
		<p class="eyebrow">Implementation notes</p>
		<h2><?php echo esc_html(lago_home_field('lp_home_architecture_title', 'Built to screen-share code, not just pages.')); ?></h2>
	</div>
	<div class="architecture-grid">
		<?php foreach ($architecture_blocks as $block) : ?>
			<?php if (!is_array($block)) { continue; } ?>
			<article>
				<span><?php echo esc_html((string) ($block['number'] ?? '')); ?></span>
				<h3><?php echo esc_html((string) ($block['title'] ?? 'Architecture')); ?></h3>
				<p><?php echo esc_html((string) ($block['body'] ?? '')); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
</section>

<section id="documentation" class="documentation-band">
	<div>
		<p class="eyebrow">Documentation</p>
		<h2><?php echo esc_html(lago_home_field('lp_home_documentation_title', 'How this site was built')); ?></h2>
	</div>
	<p><?php echo esc_html(lago_home_field('lp_home_documentation_body', 'A dedicated documentation page explains the architecture, evidence, key files, admin workflow and cache/runtime strategy. The content is editable in the classic editor while the layout stays in the theme.')); ?></p>
	<a class="button primary" href="<?php echo esc_url(home_url('/documentation/')); ?>">Open Documentation</a>
</section>

<section class="scheduler-band">
	<div>
		<p class="eyebrow">Next Step</p>
		<h2><?php echo esc_html(lago_home_field('lp_home_scheduler_title', 'Schedule the next conversation')); ?></h2>
		<p><?php echo esc_html(lago_home_field('lp_home_scheduler_body', 'Use the scheduling page to book a follow-up and review the WordPress build, integrations, code evidence and project access together.')); ?></p>
	</div>
	<a class="button primary" href="<?php echo esc_url(lago_home_field('lp_home_scheduler_url', 'https://app.fusioncore.com.br/public/agendador')); ?>" target="_blank" rel="noopener">Open Scheduler</a>
</section>

<section id="projects" class="projects-section">
	<div class="section-heading">
		<p class="eyebrow">Selected work from this server</p>
		<h2>Each card is a real custom post type with custom fields.</h2>
	</div>
	<div class="project-grid">
		<?php if ($project_query->have_posts()) : ?>
			<?php while ($project_query->have_posts()) : $project_query->the_post(); ?>
				<?php $apis = array_slice(lago_field_lines('lp_integrated_apis'), 0, 3); ?>
				<article class="project-card" style="--accent: <?php echo esc_attr(lago_project_accent()); ?>">
					<a class="project-thumb" href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url(lago_project_visual_uri()); ?>" alt="<?php echo esc_attr(get_the_title()); ?> visual">
					</a>
					<div class="project-card-top">
						<span class="project-icon"><?php echo esc_html(lago_field('lp_icon') ?: '◆'); ?></span>
						<p class="project-type"><?php echo esc_html(lago_project_type_label()); ?></p>
					</div>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p><?php echo esc_html(lago_field('lp_project_summary') ?: get_the_excerpt()); ?></p>
					<?php if ($apis) : ?>
						<ul class="pill-list">
							<?php foreach ($apis as $api) : ?>
								<li><?php echo esc_html($api); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<div class="project-meta">
						<span><?php echo esc_html(lago_field('lp_source_path')); ?></span>
					</div>
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
	<p class="section-link"><a class="button ghost" href="<?php echo esc_url(home_url('/projects/')); ?>">Open full project index</a></p>
</section>

<section id="brands" class="brands-section">
	<div class="section-heading">
		<p class="eyebrow">Served Brands</p>
		<h2>Hotels and hospitality operations in Lucas Bacellar's project ecosystem.</h2>
	</div>
	<div class="brand-grid">
		<?php if ($brand_query->have_posts()) : ?>
			<?php while ($brand_query->have_posts()) : $brand_query->the_post(); ?>
				<article class="brand-card">
					<span><?php echo esc_html(mb_substr(get_the_title(), 0, 2)); ?></span>
					<h3><?php the_title(); ?></h3>
					<p><?php echo esc_html(get_post_meta(get_the_ID(), 'lp_brand_scope', true)); ?></p>
					<?php $brand_url = (string) get_post_meta(get_the_ID(), 'lp_brand_url', true); ?>
					<?php if ($brand_url) : ?>
						<a href="<?php echo esc_url($brand_url); ?>" target="_blank" rel="noopener">Visit website</a>
					<?php endif; ?>
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
	<p class="section-link"><a class="button ghost" href="<?php echo esc_url(home_url('/brands/')); ?>">Open served brands page</a></p>
</section>

<section class="systems-section">
	<div class="systems-copy">
		<p class="eyebrow">Lucas Bacellar Highlights</p>
		<h2><?php echo esc_html(lago_home_field('lp_home_highlights_title', 'WordPress, marketing systems and integrations with product thinking.')); ?></h2>
	</div>
	<div class="systems-list">
		<?php foreach ($highlight_blocks as $block) : ?>
			<?php if (!is_array($block)) { continue; } ?>
			<p><strong><?php echo esc_html((string) ($block['title'] ?? 'Highlight')); ?>:</strong> <?php echo esc_html((string) ($block['body'] ?? '')); ?></p>
		<?php endforeach; ?>
	</div>
</section>
<?php
get_footer();
