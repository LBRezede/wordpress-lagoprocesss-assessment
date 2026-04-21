<?php
declare(strict_types=1);

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
	<?php
	$doc_summary_cards = lago_decode_json_blocks(lago_page_field('lp_doc_summary_cards'), [
		['label' => 'Editor', 'value' => 'Classic WordPress'],
		['label' => 'Layout', 'value' => 'Custom PHP theme'],
		['label' => 'Fields', 'value' => 'ACF-like plugin'],
		['label' => 'Performance', 'value' => 'Runtime + page cache'],
	]);
	$doc_nav_links = lago_decode_json_blocks(lago_page_field('lp_doc_nav_links'), [
		['href' => '#structure', 'label' => 'Structure'],
		['href' => '#editor', 'label' => 'Classic editor'],
		['href' => '#cpts', 'label' => 'CPTs and fields'],
		['href' => '#plugins', 'label' => 'Plugins'],
		['href' => '#content-guide', 'label' => 'Content guide'],
		['href' => '#evidence', 'label' => 'Evidence'],
	]);
	$doc_sections = lago_decode_json_blocks(lago_page_field('lp_doc_sections'), [
		[
			'id' => 'structure',
			'title' => 'Build Structure',
			'body' => 'The site is split into a custom theme, one toolkit plugin for content architecture and two MU plugins for runtime behavior and page cache. This keeps editing simple in wp-admin while preserving code ownership in the repository.',
			'items' => [
				'wp-content/themes/lago-process: templates, layout, CSS, navigation and page rendering.',
				'wp-content/plugins/lago-process-toolkit: CPTs, field architecture, admin menus, options and page-specific editable fields.',
				'wp-content/mu-plugins/lago-runtime-optimization.php: runtime cleanup, delayed trackers, image handling, sitemap and frontend hardening.',
				'wp-content/mu-plugins/lago-page-cache.php: anonymous visitor page cache with bypass rules and invalidation.',
			],
		],
		[
			'id' => 'editor',
			'title' => 'Editing Model',
			'body' => 'The project intentionally disables Gutenberg and works with the classic editor plus structured meta fields. The goal is to show a disciplined WordPress build that is editable in admin without relying on page builders for the core portfolio layout.',
			'items' => [
				'Pages keep long-form body content in the classic editor.',
				'Projects and brands use CPTs with structured meta fields.',
				'Special templates such as home, documentation, plugin-code, rollout, versioning, projects, brands, schedule and Zapier test expose dedicated wp-admin fields.',
				'Global header, footer, SEO defaults and shared labels are managed in Lago Portfolio > Site Settings.',
			],
		],
		[
			'id' => 'cpts',
			'title' => 'Content Types and What They Control',
			'body' => 'The portfolio is organized around real content models so the public site, admin workflow and REST output stay aligned.',
			'items' => [
				'App Projects: product sites, marketing apps and web application cases.',
				'CRM Projects: lead capture, cadences, integrations and automation layers.',
				'Delivery Projects: operational commerce and ordering/admin systems.',
				'PMS Projects: hospitality systems, booking, operations and hotel flows.',
				'Fusion AI Projects: assistants, chatbot and OpenAI-related cases.',
				'Served Brands: hospitality websites and brand-level delivery evidence.',
			],
		],
		[
			'id' => 'plugins',
			'title' => 'Plugin Summary and Implemented Features',
			'body' => 'Three custom plugins/modules organize the portfolio build.',
			'items' => [
				'Lago Process Toolkit: registers CPTs, exposes structured project fields, groups portfolio screens in the admin, adds page-specific meta boxes and provides global site settings.',
				'Lago Runtime Optimization: removes unnecessary WordPress noise, optimizes asset output, delays trackers, improves image markup and serves a lightweight sitemap.',
				'Lago Page Cache: stores generated HTML for anonymous GET traffic, bypasses sessions/admin/unsafe requests and purges cached files when content changes.',
			],
		],
		[
			'id' => 'content-guide',
			'title' => 'Content Guide',
			'body' => 'Everything visible on the site should be updated through one of four places in wp-admin.',
			'items' => [
				'Settings > General and Menus: site title and primary navigation.',
				'Lago Portfolio > Site Settings: header mark/subtitle, CTA, footer text, SEO defaults, archive labels and shared single-project labels.',
				'Pages: body copy and page-specific template fields for documentation, projects, brands, schedule, versioning, Zapier, plugin-code, home and rollout.',
				'Lago Portfolio CPTs: project summaries, stacks, integrations, credentials, evidence, icons and featured images.',
			],
		],
		[
			'id' => 'evidence',
			'title' => 'Server Evidence and Good Practices',
			'body' => 'The site itself documents both implementation and operational thinking.',
			'items' => [
				'Projects reference real systems hosted on this server and expose controlled assessment details through CPT fields.',
				'The theme preserves semantic templates instead of embedding presentation logic into the editor.',
				'Structured fields reduce accidental layout breakage and make content governance easier.',
				'Performance is handled conservatively with MU plugins instead of relying only on third-party optimization plugins.',
				'Versioning, rollback points and documentation pages make the build easier to review and safer to evolve.',
			],
		],
	]);
	?>
	<article class="documentation-page">
		<header class="doc-hero">
			<p class="eyebrow"><?php echo esc_html(lago_page_field('lp_doc_hero_eyebrow', 'Technical Documentation')); ?></p>
			<h1><?php the_title(); ?></h1>
			<p><?php echo esc_html(lago_page_field('lp_doc_hero_lede', 'A practical record of how Lucas Bacellar\'s portfolio was built, where each part is edited, and which technical evidence should be reviewed.')); ?></p>
		</header>

		<section class="doc-summary-grid">
			<?php foreach ($doc_summary_cards as $card) : ?>
				<?php if (!is_array($card)) { continue; } ?>
				<div><span><?php echo esc_html((string) ($card['label'] ?? '')); ?></span><strong><?php echo esc_html((string) ($card['value'] ?? '')); ?></strong></div>
			<?php endforeach; ?>
		</section>

		<div class="doc-layout">
			<aside class="doc-nav">
				<?php foreach ($doc_nav_links as $link) : ?>
					<?php if (!is_array($link)) { continue; } ?>
					<a href="<?php echo esc_attr((string) ($link['href'] ?? '#')); ?>"><?php echo esc_html((string) ($link['label'] ?? 'Section')); ?></a>
				<?php endforeach; ?>
			</aside>
			<div class="doc-content">
				<?php the_content(); ?>

				<?php foreach ($doc_sections as $section) : ?>
					<?php if (!is_array($section)) { continue; } ?>
					<section id="<?php echo esc_attr((string) ($section['id'] ?? 'section')); ?>">
						<h2><?php echo esc_html((string) ($section['title'] ?? 'Documentation section')); ?></h2>
						<p><?php echo esc_html((string) ($section['body'] ?? '')); ?></p>
						<?php if (!empty($section['items']) && is_array($section['items'])) : ?>
							<ul>
								<?php foreach ($section['items'] as $item) : ?>
									<li><?php echo esc_html(is_array($item) ? (string) ($item['text'] ?? '') : (string) $item); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</section>
				<?php endforeach; ?>

			</div>
		</div>
	</article>
<?php endwhile; ?>
<?php
get_footer();
