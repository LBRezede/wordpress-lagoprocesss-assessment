<?php
declare(strict_types=1);

require __DIR__ . '/../public/wp-load.php';

$options = [
	'lp_brand_mark' => 'LB',
	'lp_brand_subtitle' => 'Portfolio and Showcase',
	'lp_header_cta_label' => 'Schedule',
	'lp_header_cta_url' => home_url('/schedule-next-step/'),
	'lp_footer_text' => 'Custom WordPress theme, CPTs, ACF-like fields, REST-ready metadata, and runtime optimization mu-plugin.',
	'lp_footer_link_label' => 'Sitemap XML',
	'lp_default_seo_description' => 'Lucas Bacellar portfolio and showcase for custom WordPress development, marketing systems, hospitality platforms, integrations, Docker versioning and automation workflows.',
	'lp_schema_person_name' => 'Lucas Bacellar',
	'lp_schema_job_title' => 'WordPress Developer',
	'lp_schema_knows_about_json' => wp_json_encode(['WordPress', 'Elementor Pro', 'ACF', 'Zapier', 'CRM integrations', 'OpenAI workflows', 'Hospitality systems'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
	'lp_archive_latest_label' => 'Latest',
	'lp_archive_empty_message' => 'No content found.',
	'lp_single_client_label' => 'Client type',
	'lp_single_source_label' => 'Source',
	'lp_single_demo_label' => 'Demo',
	'lp_single_demo_link_label' => 'View link',
	'lp_single_private_label' => 'Private/internal',
	'lp_single_access_eyebrow' => 'Temporary Access',
	'lp_single_access_title' => 'Project link and demo credentials',
	'lp_single_access_body' => 'These details are editable in WordPress for each CPT and are meant for controlled assessment review.',
	'lp_single_project_label' => 'Project',
	'lp_single_login_label' => 'Login',
	'lp_single_user_label' => 'User',
	'lp_single_password_label' => 'Password',
	'lp_single_not_provided_label' => 'Not provided',
	'lp_single_user_fallback' => 'provided on request',
	'lp_single_password_fallback' => 'provided on request',
	'lp_single_stack_title' => 'Technology Stack',
	'lp_single_integrated_apis_title' => 'Integrated APIs',
	'lp_single_admin_features_title' => 'Admin features',
	'lp_single_documentation_title' => 'Project Documentation',
	'lp_single_code_evidence_title' => 'Server code evidence',
	'lp_single_integrations_title' => 'Integrations',
	'lp_single_automation_title' => 'Automation flow',
	'lp_single_outcome_title' => 'Outcome',
];

foreach ($options as $key => $value) {
	update_option($key, $value);
}

$page_meta = [
	'home' => [
		'lp_home_hero_eyebrow' => 'Lucas Bacellar Portfolio',
		'lp_home_hero_title' => 'WordPress developer for marketing systems, integrations and hospitality platforms.',
		'lp_home_hero_lede' => 'A theme-driven portfolio with separate project pages, classic WordPress editing, custom post types, ACF-like fields, cache, documentation and real server evidence.',
		'lp_home_primary_label' => 'View Projects',
		'lp_home_primary_url' => home_url('/projects/'),
		'lp_home_secondary_label' => 'Documentation',
		'lp_home_secondary_url' => home_url('/documentation/'),
		'lp_home_banner_label' => 'Featured build',
		'lp_home_banner_title' => 'Custom WordPress + integrations portfolio',
		'lp_home_banner_body' => 'Separate pages for projects, documentation, proof and served brands.',
		'lp_home_banner_badge' => 'Hospitality brand websites built with WordPress + Elementor Pro',
		'lp_home_stats_json' => wp_json_encode([
			['value' => '5', 'label' => 'Custom post types'],
			['value' => '10+', 'label' => 'Editable project fields'],
			['value' => '2', 'label' => 'MU performance/cache plugins'],
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
		'lp_home_proof_eyebrow' => 'Proof Highlights',
		'lp_home_proof_title' => 'What this portfolio proves at a technical level.',
		'lp_home_proof_blocks' => wp_json_encode([
			['title' => 'Classic Editor', 'body' => 'Gutenberg is disabled by code. Pages and CPTs open in the classic WordPress editor.'],
			['title' => 'Theme-owned layout', 'body' => 'Hero, proof blocks, brands, cards, documentation and singles are rendered by PHP theme templates.'],
			['title' => 'ACF-like fields', 'body' => 'Stack, APIs, temporary credentials, evidence and flexible sections are editable post meta.'],
			['title' => 'Real CPTs', 'body' => 'Delivery, App, PMS, CRM, Fusion AI and Served Brands are managed in the Lago Portfolio admin area.'],
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
		'lp_home_architecture_eyebrow' => 'Implementation notes',
		'lp_home_architecture_title' => 'Built to screen-share code, not just pages.',
		'lp_home_architecture_blocks' => wp_json_encode([
			['number' => '01', 'title' => 'Structured CPTs', 'body' => 'Delivery, App, PMS, CRM and Fusion AI are separate post types with dashboard icons, archives and REST fields.'],
			['number' => '02', 'title' => 'ACF-style fields', 'body' => 'Stack, APIs, automations, code evidence and flexible sections are stored as post meta and rendered by theme helpers.'],
			['number' => '03', 'title' => 'Runtime hardening', 'body' => 'The mu-plugin removes WordPress noise, delays trackers, adds image attributes and serves a lightweight sitemap.'],
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
		'lp_home_documentation_eyebrow' => 'Documentation',
		'lp_home_documentation_title' => 'How this site was built',
		'lp_home_documentation_body' => 'A dedicated documentation page explains the architecture, evidence, key files, admin workflow and cache/runtime strategy. The content is editable in the classic editor while the layout stays in the theme.',
		'lp_home_documentation_button_label' => 'Open Documentation',
		'lp_home_documentation_button_url' => home_url('/documentation/'),
		'lp_home_scheduler_eyebrow' => 'Next Step',
		'lp_home_scheduler_title' => 'Schedule the next conversation',
		'lp_home_scheduler_body' => 'Use the scheduling page to book a follow-up and review the WordPress build, integrations, code evidence and project access together.',
		'lp_home_scheduler_url' => 'https://app.fusioncore.com.br/public/agendador',
		'lp_home_scheduler_button_label' => 'Open Scheduler',
		'lp_home_projects_eyebrow' => 'Selected work from this server',
		'lp_home_projects_title' => 'Each card is a real custom post type with custom fields.',
		'lp_home_projects_button_label' => 'Open full project index',
		'lp_home_brands_eyebrow' => 'Served Brands',
		'lp_home_brands_title' => 'Hotels and hospitality operations in Lucas Bacellar\'s project ecosystem.',
		'lp_home_brands_button_label' => 'Open served brands page',
		'lp_home_highlights_eyebrow' => 'Lucas Bacellar Highlights',
		'lp_home_highlights_title' => 'WordPress, marketing systems and integrations with product thinking.',
		'lp_home_highlights_blocks' => wp_json_encode([
			['title' => 'Custom WordPress with real structure', 'body' => 'custom themes, CPTs, ACF-like fields, admin menus and code-controlled rendering.'],
			['title' => 'Flexible content without page-builder dependency', 'body' => 'reusable sections, editable admin content and theme-owned layout consistency.'],
			['title' => 'Integrations that connect marketing and operations', 'body' => 'Booking/OTA, CRM, webhooks, ad tracking, OpenAI, Google Calendar, email and internal workflows.'],
			['title' => 'Production-minded delivery', 'body' => 'documentation, conservative deployment, runtime optimization, SSL, Nginx, databases, caching and post-launch maintenance.'],
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
	],
	'documentation' => [
		'lp_doc_hero_eyebrow' => 'Technical Documentation',
		'lp_doc_hero_lede' => 'A practical record of how the portfolio was built, where each part is edited, which plugins were created and how the content governance works across the site.',
		'lp_doc_summary_cards' => wp_json_encode([
			['label' => 'Editor', 'value' => 'Classic WordPress'],
			['label' => 'Layout', 'value' => 'Custom PHP theme'],
			['label' => 'Fields', 'value' => 'ACF-like plugin'],
			['label' => 'Performance', 'value' => 'Runtime + page cache'],
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
		'lp_doc_nav_links' => wp_json_encode([
			['href' => '#structure', 'label' => 'Structure'],
			['href' => '#editor', 'label' => 'Editing model'],
			['href' => '#cpts', 'label' => 'CPTs'],
			['href' => '#plugins', 'label' => 'Plugins'],
			['href' => '#content-guide', 'label' => 'Content guide'],
			['href' => '#evidence', 'label' => 'Evidence'],
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
		'lp_doc_sections' => wp_json_encode([
			[
				'id' => 'structure',
				'title' => 'Build Structure',
				'body' => 'The project is split between one custom theme, one toolkit plugin and two MU plugins. This keeps rendering code organized, content structured and runtime behavior explicit.',
				'items' => [
					'Theme: public pages, templates, layout, CSS, typography and render helpers.',
					'Toolkit plugin: CPTs, project meta fields, special-page meta boxes and global site settings.',
					'Runtime MU plugin: performance cleanup, delayed trackers, sitemap and frontend optimizations.',
					'Page cache MU plugin: HTML caching for anonymous traffic with purge rules.',
				],
			],
			[
				'id' => 'editor',
				'title' => 'Editing Model',
				'body' => 'The site uses the classic editor and structured fields instead of a page builder-driven layout. That keeps the UI editable while preserving a stable front-end architecture.',
				'items' => [
					'Page body copy stays editable in the standard page editor.',
					'Projects and brands use dedicated CPTs with typed meta fields.',
					'Special pages expose dedicated field groups in wp-admin.',
					'Shared labels, SEO defaults, header and footer live in Lago Portfolio > Site Settings.',
				],
			],
			[
				'id' => 'cpts',
				'title' => 'CPTs and Field Architecture',
				'body' => 'The site is organized into real project categories so content, screenshots, stack descriptions and access notes remain structured and reusable.',
				'items' => [
					'Delivery Project',
					'App Project',
					'PMS Project',
					'CRM Project',
					'Fusion AI Project',
					'Served Brand',
				],
			],
			[
				'id' => 'plugins',
				'title' => 'Plugins Created for This Development',
				'body' => 'Custom plugins were created to avoid generic page-builder dependency and to document engineering practices directly in WordPress.',
				'items' => [
					'Lago Process Toolkit: registers CPTs, creates admin metaboxes, stores structured data and centralizes portfolio administration.',
					'Lago Runtime Optimization: reduces WordPress noise, controls asset behavior, improves output markup and adds sitemap/runtime safeguards.',
					'Lago Page Cache: handles full-page cache for anonymous traffic with conservative bypass rules and invalidation on content updates.',
				],
			],
			[
				'id' => 'content-guide',
				'title' => 'Guide to All Site Content',
				'body' => 'Everything visible on the site can now be managed from wp-admin through one of the channels below.',
				'items' => [
					'General WordPress settings and navigation menu.',
					'Lago Portfolio > Site Settings for header, footer, SEO defaults and shared labels.',
					'Each special Page for body copy and page-specific field groups.',
					'Each CPT entry for project data, credentials, stack, evidence and featured images.',
				],
			],
			[
				'id' => 'evidence',
				'title' => 'Practices and Evidence',
				'body' => 'The build reflects a production-minded WordPress approach, combining structured content, careful caching, explicit source control and documentation-first delivery.',
				'items' => [
					'Code-driven theme templates instead of layout-by-editor.',
					'Structured meta fields for predictable content governance.',
					'Custom runtime hardening and caching for performance.',
					'Git rollback points and documentation pages for safer evolution.',
				],
			],
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
	],
	'projects' => [
		'lp_projects_eyebrow' => 'Project Index',
		'lp_projects_lede' => 'Published project pages with documentation, system access, technology stack, integrated APIs and visual context.',
		'lp_projects_stack_label' => 'Stack',
		'lp_projects_button_label' => 'Open project page',
	],
	'brands' => [
		'lp_brands_eyebrow' => 'Served Brands',
		'lp_brands_lede' => 'Hospitality brands and operations connected to Lucas Bacellar\'s WordPress, marketing and systems work. All listed websites were built with WordPress and Elementor Pro.',
		'lp_brands_stack_prefix' => 'Built with:',
		'lp_brands_button_label' => 'Visit website',
	],
	'versioning' => [
		'lp_versioning_eyebrow' => 'Deployment Evidence',
		'lp_versioning_cards' => wp_json_encode([
			['number' => '01', 'title' => 'Docker-ready project', 'body' => 'The subdomain has a dedicated Docker Compose file for local review of the WordPress stack without touching the other applications on this server.', 'code' => 'lagoprocess/docker-compose.yml'],
			['number' => '02', 'title' => 'Git versioning scope', 'body' => 'The repository scope is limited to the portfolio assets: theme, plugin, mu-plugins, Docker files and documentation. WordPress core, uploads, cache and secrets are ignored.', 'code' => 'lagoprocess/.gitignore'],
			['number' => '03', 'title' => 'GitHub publication', 'body' => 'The project is connected to GitHub and rollback tags can be created before sensitive changes.', 'code' => 'git push origin main && git push origin TAG_NAME'],
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
		'lp_versioning_commands_title' => 'Repository commands',
		'lp_versioning_commands_code' => "cd /var/www/app.fusioncore.com.br/lagoprocess\n\ngit status\ngit add public/wp-content\ngit commit -m \"Describe the change\"\ngit tag -a rollback-tag-name -m \"Rollback point\"\ngit push origin main\ngit push origin rollback-tag-name",
	],
	'schedule-next-step' => [
		'lp_schedule_eyebrow' => 'Next Step',
		'lp_schedule_card_title' => 'Book a follow-up review',
		'lp_schedule_card_body' => 'Use the FusionCore scheduler to choose a time for the next conversation and walk through the WordPress build, integrations, project credentials and deployment evidence.',
		'lp_schedule_button_label' => 'Open Scheduling Page',
		'lp_schedule_button_url' => 'https://app.fusioncore.com.br/public/agendador',
	],
	'zapier-integration' => [
		'lp_zapier_eyebrow' => 'Marketing Automation',
		'lp_zapier_panel_title' => 'Run a Zapier webhook test',
		'lp_zapier_panel_body' => 'Paste a Zapier Catch Hook URL and optional bearer token. Credentials are used only for this request and are not stored in WordPress.',
		'lp_zapier_webhook_label' => 'Zapier webhook URL',
		'lp_zapier_api_key_label' => 'Optional bearer token / API key',
		'lp_zapier_test_name_label' => 'Test name',
		'lp_zapier_test_email_label' => 'Test email',
		'lp_zapier_submit_label' => 'Execute Zapier Test',
		'lp_zapier_invalid_url_msg' => 'Enter a valid Zapier webhook URL.',
		'lp_zapier_success_msg' => 'Zapier webhook executed.',
		'lp_zapier_default_name' => 'Lucas Bacellar Portfolio Test',
	],
	'plugin-code' => [
		'lp_plugin_code_hero_eyebrow' => 'Code Evidence',
		'lp_plugin_code_api_eyebrow' => 'API Integration Pattern',
		'lp_plugin_code_api_title' => 'Google Calendar scheduling example',
		'lp_plugin_code_api_body' => 'This example shows how the scheduler or CRM layer can create a Calendar event with Google Meet. Secrets are represented by environment variables only; no private key or token is printed on this page.',
		'lp_plugin_code_api_code' => <<<'PHP'
<?php
declare(strict_types=1);

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

$client = new Client();
$client->setApplicationName('Lucas Bacellar Portfolio Scheduler');
$client->setAuthConfig([
    'type' => 'service_account',
    'client_email' => getenv('GOOGLE_CLIENT_EMAIL'),
    'private_key' => str_replace('\n', "\n", (string) getenv('GOOGLE_PRIVATE_KEY')),
]);
$client->addScope(Calendar::CALENDAR_EVENTS);

$calendar = new Calendar($client);
$event = new Event([
    'summary' => 'Portfolio follow-up call',
    'description' => 'Assessment follow-up scheduled from the portfolio.',
]);
PHP,
		'lp_plugin_code_summary_cards' => wp_json_encode([
			['label' => 'Toolkit', 'value' => 'CPTs, fields, REST'],
			['label' => 'MU Runtime', 'value' => 'Optimization layer'],
			['label' => 'MU Cache', 'value' => 'Anonymous page cache'],
			['label' => 'API Example', 'value' => 'Google Calendar'],
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
		'lp_plugin_code_files' => wp_json_encode([
			[
				'eyebrow' => 'plugins/lago-process-toolkit/lagoprocess-toolkit.php',
				'title' => 'Lago Process Toolkit Plugin',
				'description' => 'Registers portfolio custom post types, admin menu entries, ACF-like fields, classic editor behavior, REST fields and the editable page field layers.',
				'code' => "<?php\nadd_filter('use_block_editor_for_post', '__return_false', 100);\n\nfunction lp_project_types(): array {\n    return [\n        'lp_app' => ['singular' => 'App Project', 'slug' => 'apps'],\n        'lp_crm' => ['singular' => 'CRM Project', 'slug' => 'crm'],\n    ];\n}\n",
			],
			[
				'eyebrow' => 'mu-plugins/lago-runtime-optimization.php',
				'title' => 'Lago Runtime Optimization MU Plugin',
				'description' => 'Handles conservative performance optimizations, delayed trackers, image dimensions, sitemap output and runtime hardening.',
				'code' => "<?php\nadd_action('template_redirect', static function (): void {\n    if (is_admin() || wp_doing_ajax()) {\n        return;\n    }\n\n    header_remove('X-Pingback');\n}, 1);\n",
			],
			[
				'eyebrow' => 'mu-plugins/lago-page-cache.php',
				'title' => 'Lago Page Cache MU Plugin',
				'description' => 'Provides a small full-page cache for anonymous visitors with safe bypass and invalidation rules.',
				'code' => "<?php\nfunction lago_page_cache_should_bypass(): bool {\n    if (is_user_logged_in() || wp_doing_ajax()) {\n        return true;\n    }\n\n    return \$_SERVER['REQUEST_METHOD'] !== 'GET';\n}\n",
			],
		], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
	],
];

foreach ($page_meta as $slug => $fields) {
	$page = get_page_by_path($slug);
	if (!$page instanceof WP_Post) {
		continue;
	}

	foreach ($fields as $key => $value) {
		update_post_meta($page->ID, $key, $value);
	}
}

echo "seeded\n";
