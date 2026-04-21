<?php
declare(strict_types=1);

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
	<article class="documentation-page">
		<header class="doc-hero">
			<p class="eyebrow">Technical Documentation</p>
			<h1><?php the_title(); ?></h1>
			<p>A practical record of how Lucas Bacellar's portfolio was built, where each part is edited, and which technical evidence should be reviewed.</p>
		</header>

		<section class="doc-summary-grid">
			<div><span>Editor</span><strong>Classic WordPress</strong></div>
			<div><span>Layout</span><strong>Custom PHP theme</strong></div>
			<div><span>Fields</span><strong>ACF-like plugin</strong></div>
			<div><span>Performance</span><strong>Runtime + page cache</strong></div>
		</section>

		<div class="doc-layout">
			<aside class="doc-nav">
				<a href="#structure">Structure</a>
				<a href="#editor">Classic editor</a>
				<a href="#cpts">CPTs and fields</a>
				<a href="#cache">Cache system</a>
				<a href="#evidence">Evidence</a>
			</aside>
			<div class="doc-content">
				<?php the_content(); ?>

				<section id="structure">
					<h2>Build Structure</h2>
					<ul>
						<li><code>wp-content/themes/lago-process</code>: templates, visual layout, typography, grids and public pages.</li>
						<li><code>wp-content/plugins/lago-process-toolkit</code>: CPTs, editable fields, REST fields and the Lago Portfolio admin menu.</li>
						<li><code>wp-content/mu-plugins/lago-runtime-optimization.php</code>: runtime optimization, asset cleanup, sitemap and delayed trackers.</li>
						<li><code>wp-content/mu-plugins/lago-page-cache.php</code>: visitor page cache with safe bypass rules and automatic invalidation.</li>
						<li><code>deployment/update-lagoprocess-project-fields.php</code>: seed script for projects, brands, temporary credentials and documentation.</li>
					</ul>
				</section>

				<section id="editor">
					<h2>Classic Editor, Not Gutenberg</h2>
					<p>The toolkit plugin applies <code>use_block_editor_for_post</code> and <code>use_block_editor_for_post_type</code> filters returning false. Pages, brands and project CPTs open in the classic WordPress editor.</p>
					<p>Content stays editable in the dashboard, while core layouts remain in the theme to avoid page-builder dependency.</p>
				</section>

				<section id="cpts">
					<h2>CPTs and Custom Fields</h2>
					<p>The <strong>Lago Portfolio</strong> admin menu groups Delivery, App, PMS, CRM, Fusion AI and Served Brands. Each project includes fields for technology stack, integrated APIs, automations, evidence, project links and temporary access credentials.</p>
				</section>

				<section id="cache">
					<h2>Cache System</h2>
					<p>The site uses a custom MU plugin page cache to demonstrate production performance work without relying on a third-party cache plugin. It caches anonymous GET requests, bypasses admin/logged-in/POST/query-string traffic, sends cache headers and clears cached HTML when content changes.</p>
				</section>

				<section id="evidence">
					<h2>Server Evidence</h2>
					<ul>
						<li><code>/var/www/delivery.fusioncore.com.br</code>: Laravel, Filament, Sanctum, Guzzle, Vite and Tailwind.</li>
						<li><code>/var/www/fusioncore.com.br</code>: Astro, Node adapter, Tailwind and Nginx deployment.</li>
						<li><code>/var/www/raizes.fusioncore.com.br/app</code>: PMS, booking engine, channel manager, OpenAI, WhatsApp, revenue and OTA jobs.</li>
						<li><code>/var/www/app.fusioncore.com.br</code>: CRM, Google API Client, webhooks, email flows, cadences and internal scripts.</li>
					</ul>
				</section>

			</div>
		</div>
	</article>
<?php endwhile; ?>
<?php
get_footer();
