<?php
/**
 * Plugin Name: Lago Process Toolkit
 * Description: Custom post types, ACF-like fields, flexible sections, and assessment helpers for the Lago Process portfolio.
 * Version: 1.0.0
 * Author: FusionCore
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

const LP_TOOLKIT_VERSION = '1.0.0';

// Force the classic editor so reviewers can see a traditional WordPress editing workflow.
add_filter('use_block_editor_for_post', '__return_false', 100);
add_filter('use_block_editor_for_post_type', '__return_false', 100);

// Central registry for the project custom post types shown under the Lago Portfolio admin menu.
function lp_project_types(): array {
	return [
		'lp_delivery' => [
			'singular' => 'Delivery Project',
			'plural'   => 'Delivery Projects',
			'slug'     => 'delivery',
			'icon'     => 'dashicons-store',
			'accent'   => '#f97316',
		],
		'lp_app' => [
			'singular' => 'App Project',
			'plural'   => 'App Projects',
			'slug'     => 'apps',
			'icon'     => 'dashicons-smartphone',
			'accent'   => '#0ea5e9',
		],
		'lp_pms' => [
			'singular' => 'PMS Project',
			'plural'   => 'PMS Projects',
			'slug'     => 'pms',
			'icon'     => 'dashicons-building',
			'accent'   => '#14b8a6',
		],
		'lp_crm' => [
			'singular' => 'CRM Project',
			'plural'   => 'CRM Projects',
			'slug'     => 'crm',
			'icon'     => 'dashicons-groups',
			'accent'   => '#6366f1',
		],
		'lp_fusion_ai' => [
			'singular' => 'Fusion AI Project',
			'plural'   => 'Fusion AI Projects',
			'slug'     => 'fusion-ai',
			'icon'     => 'dashicons-superhero',
			'accent'   => '#111827',
		],
	];
}

// Served brands are intentionally separated from project case studies.
function lp_brand_type(): array {
	return [
		'lp_brand' => [
			'singular' => 'Served Brand',
			'plural'   => 'Served Brands',
			'slug'     => 'marcas',
			'icon'     => 'dashicons-awards',
			'accent'   => '#525252',
		],
	];
}

// Register all portfolio content models with REST support, archives and dashboard icons.
add_action('init', function (): void {
	foreach (lp_project_types() as $post_type => $config) {
		register_post_type($post_type, [
			'labels' => [
				'name'               => $config['plural'],
				'singular_name'      => $config['singular'],
				'add_new_item'       => 'Add ' . $config['singular'],
				'edit_item'          => 'Edit ' . $config['singular'],
				'new_item'           => 'New ' . $config['singular'],
				'view_item'          => 'View ' . $config['singular'],
				'search_items'       => 'Search ' . $config['plural'],
				'not_found'          => 'No projects found',
				'menu_name'          => $config['plural'],
			],
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => ['slug' => $config['slug']],
			'show_in_menu' => 'lago-portfolio',
			'menu_icon'    => $config['icon'],
			'show_in_rest' => true,
			'supports'     => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
			'taxonomies'   => ['post_tag'],
		]);
	}

	foreach (lp_brand_type() as $post_type => $config) {
		register_post_type($post_type, [
			'labels' => [
				'name'               => $config['plural'],
				'singular_name'      => $config['singular'],
				'add_new_item'       => 'Add ' . $config['singular'],
				'edit_item'          => 'Edit ' . $config['singular'],
				'new_item'           => 'New ' . $config['singular'],
				'view_item'          => 'View ' . $config['singular'],
				'search_items'       => 'Search ' . $config['plural'],
				'not_found'          => 'No brands found',
				'menu_name'          => $config['plural'],
			],
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => ['slug' => $config['slug']],
			'show_in_menu' => 'lago-portfolio',
			'menu_icon'    => $config['icon'],
			'show_in_rest' => true,
			'supports'     => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
		]);
	}
}, 20);

// Project fields mimic the ACF workflow without requiring ACF as a dependency.
function lp_acf_like_fields(): array {
	return [
		'lp_project_summary' => ['label' => 'Project summary', 'type' => 'textarea'],
		'lp_client_type'     => ['label' => 'Client / business type', 'type' => 'text'],
		'lp_stack'           => ['label' => 'Stack and tools', 'type' => 'text'],
		'lp_stack_used'      => ['label' => 'Technology stack (one per line)', 'type' => 'textarea'],
		'lp_integrated_apis' => ['label' => 'Integrated APIs (one per line)', 'type' => 'textarea'],
		'lp_integrations'    => ['label' => 'Integrations / automations', 'type' => 'textarea'],
		'lp_automation_flow' => ['label' => 'Automation flow', 'type' => 'textarea'],
		'lp_admin_features'  => ['label' => 'Admin / dashboard features', 'type' => 'textarea'],
		'lp_code_evidence'   => ['label' => 'Server code evidence', 'type' => 'textarea'],
		'lp_source_path'     => ['label' => 'Source path / server project', 'type' => 'text'],
		'lp_project_url'     => ['label' => 'Project URL', 'type' => 'url'],
		'lp_access_url'      => ['label' => 'Access / login URL', 'type' => 'url'],
		'lp_demo_user'       => ['label' => 'Temporary user', 'type' => 'text'],
		'lp_demo_password'   => ['label' => 'Temporary password', 'type' => 'text'],
		'lp_access_notes'    => ['label' => 'Temporary access notes', 'type' => 'textarea'],
		'lp_results'         => ['label' => 'Results / business outcome', 'type' => 'textarea'],
		'lp_demo_url'        => ['label' => 'Demo or case-study URL', 'type' => 'url'],
		'lp_icon'            => ['label' => 'Card icon', 'type' => 'text'],
		'lp_flexible_json'   => ['label' => 'Flexible sections JSON', 'type' => 'textarea'],
	];
}

// Brand fields keep client/brand evidence editable from the WordPress admin.
function lp_brand_fields(): array {
	return [
		'lp_brand_url'   => ['label' => 'Brand website', 'type' => 'url'],
		'lp_brand_scope' => ['label' => 'Scope / work type', 'type' => 'textarea'],
		'lp_brand_stack' => ['label' => 'Stack / tools', 'type' => 'textarea'],
	];
}

// Homepage fields keep the public layout in the theme while letting copy stay editable in WordPress.
function lp_home_fields(): array {
	return [
		'lp_home_hero_eyebrow' => ['label' => 'Hero eyebrow', 'type' => 'text'],
		'lp_home_hero_title' => ['label' => 'Hero title', 'type' => 'textarea'],
		'lp_home_hero_lede' => ['label' => 'Hero intro text', 'type' => 'textarea'],
		'lp_home_primary_label' => ['label' => 'Primary button label', 'type' => 'text'],
		'lp_home_primary_url' => ['label' => 'Primary button URL', 'type' => 'url'],
		'lp_home_secondary_label' => ['label' => 'Secondary button label', 'type' => 'text'],
		'lp_home_secondary_url' => ['label' => 'Secondary button URL', 'type' => 'url'],
		'lp_home_banner_label' => ['label' => 'Hero image card label', 'type' => 'text'],
		'lp_home_banner_title' => ['label' => 'Hero image card title', 'type' => 'text'],
		'lp_home_banner_body' => ['label' => 'Hero image card body', 'type' => 'textarea'],
		'lp_home_banner_badge' => ['label' => 'Hero image card badge', 'type' => 'text'],
		'lp_home_stats_json' => ['label' => 'Hero stats JSON', 'type' => 'textarea'],
		'lp_home_proof_eyebrow' => ['label' => 'Proof eyebrow', 'type' => 'text'],
		'lp_home_proof_title' => ['label' => 'Proof section title', 'type' => 'textarea'],
		'lp_home_proof_blocks' => ['label' => 'Proof blocks JSON', 'type' => 'textarea'],
		'lp_home_architecture_eyebrow' => ['label' => 'Architecture eyebrow', 'type' => 'text'],
		'lp_home_architecture_title' => ['label' => 'Architecture section title', 'type' => 'textarea'],
		'lp_home_architecture_blocks' => ['label' => 'Architecture blocks JSON', 'type' => 'textarea'],
		'lp_home_documentation_eyebrow' => ['label' => 'Documentation eyebrow', 'type' => 'text'],
		'lp_home_documentation_title' => ['label' => 'Documentation band title', 'type' => 'text'],
		'lp_home_documentation_body' => ['label' => 'Documentation band body', 'type' => 'textarea'],
		'lp_home_documentation_button_label' => ['label' => 'Documentation button label', 'type' => 'text'],
		'lp_home_documentation_button_url' => ['label' => 'Documentation button URL', 'type' => 'url'],
		'lp_home_scheduler_eyebrow' => ['label' => 'Scheduler eyebrow', 'type' => 'text'],
		'lp_home_scheduler_title' => ['label' => 'Scheduler CTA title', 'type' => 'text'],
		'lp_home_scheduler_body' => ['label' => 'Scheduler CTA body', 'type' => 'textarea'],
		'lp_home_scheduler_url' => ['label' => 'Scheduler URL', 'type' => 'url'],
		'lp_home_scheduler_button_label' => ['label' => 'Scheduler button label', 'type' => 'text'],
		'lp_home_projects_eyebrow' => ['label' => 'Projects eyebrow', 'type' => 'text'],
		'lp_home_projects_title' => ['label' => 'Projects title', 'type' => 'textarea'],
		'lp_home_projects_button_label' => ['label' => 'Projects button label', 'type' => 'text'],
		'lp_home_brands_eyebrow' => ['label' => 'Brands eyebrow', 'type' => 'text'],
		'lp_home_brands_title' => ['label' => 'Brands title', 'type' => 'textarea'],
		'lp_home_brands_button_label' => ['label' => 'Brands button label', 'type' => 'text'],
		'lp_home_highlights_eyebrow' => ['label' => 'Highlights eyebrow', 'type' => 'text'],
		'lp_home_highlights_title' => ['label' => 'Highlights section title', 'type' => 'textarea'],
		'lp_home_highlights_blocks' => ['label' => 'Highlights blocks JSON', 'type' => 'textarea'],
	];
}

// Rollout page fields keep the custom migration panel editable from the classic page editor.
function lp_rollout_fields(): array {
	return [
		'lp_rollout_hero_eyebrow' => ['label' => 'Hero eyebrow', 'type' => 'text'],
		'lp_rollout_hero_lede' => ['label' => 'Hero intro text', 'type' => 'textarea'],
		'lp_rollout_primary_label' => ['label' => 'Primary button label', 'type' => 'text'],
		'lp_rollout_primary_url' => ['label' => 'Primary button URL', 'type' => 'text'],
		'lp_rollout_secondary_label' => ['label' => 'Secondary button label', 'type' => 'text'],
		'lp_rollout_secondary_url' => ['label' => 'Secondary button URL', 'type' => 'url'],
		'lp_rollout_stats_json' => ['label' => 'Hero stats JSON', 'type' => 'textarea'],
		'lp_rollout_hero_card_label' => ['label' => 'Hero card eyebrow', 'type' => 'text'],
		'lp_rollout_hero_card_title' => ['label' => 'Hero card title', 'type' => 'textarea'],
		'lp_rollout_hero_card_body' => ['label' => 'Hero card body', 'type' => 'textarea'],
		'lp_rollout_proof_eyebrow' => ['label' => 'Proof section eyebrow', 'type' => 'text'],
		'lp_rollout_proof_title' => ['label' => 'Proof section title', 'type' => 'textarea'],
		'lp_rollout_proof_blocks' => ['label' => 'Proof blocks JSON', 'type' => 'textarea'],
		'lp_rollout_story_eyebrow' => ['label' => 'Story eyebrow', 'type' => 'text'],
		'lp_rollout_story_title' => ['label' => 'Story title', 'type' => 'textarea'],
		'lp_rollout_story_body' => ['label' => 'Story body paragraph 1', 'type' => 'textarea'],
		'lp_rollout_story_body_2' => ['label' => 'Story body paragraph 2', 'type' => 'textarea'],
		'lp_rollout_timeline_eyebrow' => ['label' => 'Timeline eyebrow', 'type' => 'text'],
		'lp_rollout_timeline_steps' => ['label' => 'Timeline steps JSON', 'type' => 'textarea'],
		'lp_rollout_band_eyebrow' => ['label' => 'Band eyebrow', 'type' => 'text'],
		'lp_rollout_band_title' => ['label' => 'Band title', 'type' => 'textarea'],
		'lp_rollout_band_body' => ['label' => 'Band body', 'type' => 'textarea'],
		'lp_rollout_screens_eyebrow' => ['label' => 'Screens eyebrow', 'type' => 'text'],
		'lp_rollout_screens_title' => ['label' => 'Screens title', 'type' => 'textarea'],
		'lp_rollout_screens_json' => ['label' => 'Screens JSON', 'type' => 'textarea'],
	];
}

// Plugin code page fields keep code-page labels, summaries and file registry editable.
function lp_plugin_code_fields(): array {
	return [
		'lp_plugin_code_hero_eyebrow'   => ['label' => 'Hero eyebrow', 'type' => 'text'],
		'lp_plugin_code_summary_cards' => ['label' => 'Summary cards JSON', 'type' => 'textarea'],
		'lp_plugin_code_api_eyebrow'   => ['label' => 'API section eyebrow', 'type' => 'text'],
		'lp_plugin_code_api_title'     => ['label' => 'API section title', 'type' => 'text'],
		'lp_plugin_code_api_body'      => ['label' => 'API section body', 'type' => 'textarea'],
		'lp_plugin_code_api_code'      => ['label' => 'API example code', 'type' => 'textarea'],
		'lp_plugin_code_files'         => ['label' => 'Code panels JSON', 'type' => 'textarea'],
	];
}

function lp_global_fields(): array {
	return [
		'lp_brand_mark'                  => ['label' => 'Header brand mark', 'type' => 'text'],
		'lp_brand_subtitle'              => ['label' => 'Header subtitle', 'type' => 'text'],
		'lp_header_cta_label'            => ['label' => 'Header CTA label', 'type' => 'text'],
		'lp_header_cta_url'              => ['label' => 'Header CTA URL', 'type' => 'url'],
		'lp_footer_text'                 => ['label' => 'Footer text', 'type' => 'textarea'],
		'lp_footer_link_label'           => ['label' => 'Footer link label', 'type' => 'text'],
		'lp_default_seo_description'     => ['label' => 'Default SEO description', 'type' => 'textarea'],
		'lp_default_social_image_url'    => ['label' => 'Default social image URL', 'type' => 'url'],
		'lp_schema_person_name'          => ['label' => 'Schema person name', 'type' => 'text'],
		'lp_schema_job_title'            => ['label' => 'Schema job title', 'type' => 'text'],
		'lp_schema_knows_about_json'     => ['label' => 'Schema knowsAbout JSON', 'type' => 'textarea'],
		'lp_archive_latest_label'        => ['label' => 'Archive fallback eyebrow', 'type' => 'text'],
		'lp_archive_empty_message'       => ['label' => 'Archive empty message', 'type' => 'text'],
		'lp_single_client_label'         => ['label' => 'Single project client label', 'type' => 'text'],
		'lp_single_source_label'         => ['label' => 'Single project source label', 'type' => 'text'],
		'lp_single_demo_label'           => ['label' => 'Single project demo label', 'type' => 'text'],
		'lp_single_demo_link_label'      => ['label' => 'Single project demo link label', 'type' => 'text'],
		'lp_single_private_label'        => ['label' => 'Single project private demo label', 'type' => 'text'],
		'lp_single_access_eyebrow'       => ['label' => 'Access section eyebrow', 'type' => 'text'],
		'lp_single_access_title'         => ['label' => 'Access section title', 'type' => 'text'],
		'lp_single_access_body'          => ['label' => 'Access section body', 'type' => 'textarea'],
		'lp_single_project_label'        => ['label' => 'Access project label', 'type' => 'text'],
		'lp_single_login_label'          => ['label' => 'Access login label', 'type' => 'text'],
		'lp_single_user_label'           => ['label' => 'Access user label', 'type' => 'text'],
		'lp_single_password_label'       => ['label' => 'Access password label', 'type' => 'text'],
		'lp_single_not_provided_label'   => ['label' => 'Access not provided label', 'type' => 'text'],
		'lp_single_user_fallback'        => ['label' => 'Access user fallback', 'type' => 'text'],
		'lp_single_password_fallback'    => ['label' => 'Access password fallback', 'type' => 'text'],
		'lp_single_stack_title'          => ['label' => 'Stack section title', 'type' => 'text'],
		'lp_single_integrated_apis_title'=> ['label' => 'Integrated APIs section title', 'type' => 'text'],
		'lp_single_admin_features_title' => ['label' => 'Admin features section title', 'type' => 'text'],
		'lp_single_documentation_title'  => ['label' => 'Documentation section title', 'type' => 'text'],
		'lp_single_code_evidence_title'  => ['label' => 'Code evidence section title', 'type' => 'text'],
		'lp_single_integrations_title'   => ['label' => 'Integrations section title', 'type' => 'text'],
		'lp_single_automation_title'     => ['label' => 'Automation section title', 'type' => 'text'],
		'lp_single_outcome_title'        => ['label' => 'Outcome section title', 'type' => 'text'],
	];
}

function lp_page_fields_for_slug(string $slug): array {
	return match ($slug) {
		'documentation' => [
			'lp_doc_hero_eyebrow'     => ['label' => 'Hero eyebrow', 'type' => 'text'],
			'lp_doc_hero_lede'        => ['label' => 'Hero lede', 'type' => 'textarea'],
			'lp_doc_summary_cards'    => ['label' => 'Summary cards JSON', 'type' => 'textarea'],
			'lp_doc_nav_links'        => ['label' => 'Navigation links JSON', 'type' => 'textarea'],
			'lp_doc_sections'         => ['label' => 'Documentation sections JSON', 'type' => 'textarea'],
		],
		'projects' => [
			'lp_projects_eyebrow'     => ['label' => 'Hero eyebrow', 'type' => 'text'],
			'lp_projects_lede'        => ['label' => 'Hero lede', 'type' => 'textarea'],
			'lp_projects_stack_label' => ['label' => 'Stack label', 'type' => 'text'],
			'lp_projects_button_label'=> ['label' => 'Card button label', 'type' => 'text'],
		],
		'brands' => [
			'lp_brands_eyebrow'       => ['label' => 'Hero eyebrow', 'type' => 'text'],
			'lp_brands_lede'          => ['label' => 'Hero lede', 'type' => 'textarea'],
			'lp_brands_stack_prefix'  => ['label' => 'Stack prefix', 'type' => 'text'],
			'lp_brands_button_label'  => ['label' => 'Card button label', 'type' => 'text'],
		],
		'versioning' => [
			'lp_versioning_eyebrow'   => ['label' => 'Hero eyebrow', 'type' => 'text'],
			'lp_versioning_cards'     => ['label' => 'Version cards JSON', 'type' => 'textarea'],
			'lp_versioning_commands_title' => ['label' => 'Commands panel title', 'type' => 'text'],
			'lp_versioning_commands_code'  => ['label' => 'Commands panel code', 'type' => 'textarea'],
		],
		'schedule-next-step' => [
			'lp_schedule_eyebrow'     => ['label' => 'Hero eyebrow', 'type' => 'text'],
			'lp_schedule_card_title'  => ['label' => 'Card title', 'type' => 'text'],
			'lp_schedule_card_body'   => ['label' => 'Card body', 'type' => 'textarea'],
			'lp_schedule_button_label'=> ['label' => 'Button label', 'type' => 'text'],
			'lp_schedule_button_url'  => ['label' => 'Button URL', 'type' => 'url'],
		],
		'zapier-integration' => [
			'lp_zapier_eyebrow'         => ['label' => 'Hero eyebrow', 'type' => 'text'],
			'lp_zapier_panel_title'     => ['label' => 'Panel title', 'type' => 'text'],
			'lp_zapier_panel_body'      => ['label' => 'Panel body', 'type' => 'textarea'],
			'lp_zapier_webhook_label'   => ['label' => 'Webhook field label', 'type' => 'text'],
			'lp_zapier_api_key_label'   => ['label' => 'API key field label', 'type' => 'text'],
			'lp_zapier_test_name_label' => ['label' => 'Test name field label', 'type' => 'text'],
			'lp_zapier_test_email_label'=> ['label' => 'Test email field label', 'type' => 'text'],
			'lp_zapier_submit_label'    => ['label' => 'Submit button label', 'type' => 'text'],
			'lp_zapier_invalid_url_msg' => ['label' => 'Invalid URL message', 'type' => 'text'],
			'lp_zapier_success_msg'     => ['label' => 'Success message', 'type' => 'text'],
			'lp_zapier_default_name'    => ['label' => 'Default test name', 'type' => 'text'],
		],
		default => [],
	};
}

function lp_is_rollout_page(WP_Post $post): bool {
	return $post->post_type === 'page' && $post->post_name === 'rollout-custom-panel';
}

function lp_is_plugin_code_page(WP_Post $post): bool {
	return $post->post_type === 'page' && $post->post_name === 'plugin-code';
}

function lp_is_project_type(string $post_type): bool {
	return array_key_exists($post_type, lp_project_types());
}

// Attach the custom field groups to project, brand and page editing screens.
add_action('add_meta_boxes', function (): void {
	foreach (array_keys(lp_project_types()) as $post_type) {
		add_meta_box(
			'lp_acf_like_fields',
			'ACF-like Project Fields',
			'lp_render_project_fields_box',
			$post_type,
			'normal',
			'high'
		);
	}

	add_meta_box(
		'lp_brand_fields',
		'Brand Details',
		'lp_render_brand_fields_box',
		'lp_brand',
		'normal',
		'high'
	);

	add_meta_box(
		'lp_home_fields',
		'Editable Home Sections',
		'lp_render_home_fields_box',
		'page',
		'normal',
		'high'
	);

	add_meta_box(
		'lp_rollout_fields',
		'Editable Rollout Sections',
		'lp_render_rollout_fields_box',
		'page',
		'normal',
		'high'
	);

	add_meta_box(
		'lp_plugin_code_fields',
		'Editable Plugin Code Sections',
		'lp_render_plugin_code_fields_box',
		'page',
		'normal',
		'high'
	);

	add_meta_box(
		'lp_page_specific_fields',
		'Editable Page Sections',
		'lp_render_page_specific_fields_box',
		'page',
		'normal',
		'high'
	);
});

// Render the project meta box used as an ACF-like field layer.
function lp_render_project_fields_box(WP_Post $post): void {
	wp_nonce_field('lp_save_project_fields', 'lp_project_fields_nonce');
	$fields = lp_acf_like_fields();
	?>
	<div class="lp-fields">
		<p>This lightweight field layer mimics the ACF workflow used in custom marketing builds: structured project data, reusable field helpers, and flexible content stored as post meta.</p>
		<?php foreach ($fields as $key => $field) :
			$value = (string) get_post_meta($post->ID, $key, true);
			?>
			<p>
				<label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($field['label']); ?></strong></label><br>
				<?php if ($field['type'] === 'textarea') : ?>
					<textarea id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" rows="<?php echo $key === 'lp_flexible_json' ? 8 : 3; ?>" style="width:100%;font-family:monospace;"><?php echo esc_textarea($value); ?></textarea>
				<?php else : ?>
					<input id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" type="<?php echo esc_attr($field['type']); ?>" value="<?php echo esc_attr($value); ?>" style="width:100%;">
				<?php endif; ?>
			</p>
		<?php endforeach; ?>
		<p><button type="button" class="button" id="lp-insert-flexible-example">Insert flexible section example</button></p>
	</div>
	<?php
}

// Render the served brand fields used on the public brand page.
function lp_render_brand_fields_box(WP_Post $post): void {
	wp_nonce_field('lp_save_brand_fields', 'lp_brand_fields_nonce');
	?>
	<div class="lp-fields">
		<p>Editable fields used to display served brands in the portfolio.</p>
		<?php foreach (lp_brand_fields() as $key => $field) :
			$value = (string) get_post_meta($post->ID, $key, true);
			?>
			<p>
				<label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($field['label']); ?></strong></label><br>
				<?php if ($field['type'] === 'textarea') : ?>
					<textarea id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" rows="3" style="width:100%;font-family:monospace;"><?php echo esc_textarea($value); ?></textarea>
				<?php else : ?>
					<input id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" type="<?php echo esc_attr($field['type']); ?>" value="<?php echo esc_attr($value); ?>" style="width:100%;">
				<?php endif; ?>
			</p>
		<?php endforeach; ?>
	</div>
	<?php
}

// Render the editable homepage sections, including JSON-based repeatable blocks.
function lp_render_home_fields_box(WP_Post $post): void {
	if ($post->post_name !== 'home') {
		echo '<p>These homepage fields are only used by the page with slug <code>home</code>.</p>';
		return;
	}

	wp_nonce_field('lp_save_home_fields', 'lp_home_fields_nonce');
	?>
	<div class="lp-fields">
		<p>Edit the homepage copy and repeatable blocks here. The public layout remains controlled by the theme, but the text, CTAs and blocks are managed from this classic WordPress editor.</p>
		<p>Use JSON arrays for block fields. Example: <code>[{"title":"Classic Editor","body":"Pages and CPTs open in the classic editor."}]</code></p>
		<?php foreach (lp_home_fields() as $key => $field) :
			$value = (string) get_post_meta($post->ID, $key, true);
			?>
			<p>
				<label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($field['label']); ?></strong></label><br>
				<?php if ($field['type'] === 'textarea') : ?>
					<textarea id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" rows="<?php echo str_contains($key, 'blocks') ? 7 : 3; ?>" style="width:100%;font-family:monospace;"><?php echo esc_textarea($value); ?></textarea>
				<?php else : ?>
					<input id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" type="<?php echo esc_attr($field['type']); ?>" value="<?php echo esc_attr($value); ?>" style="width:100%;">
				<?php endif; ?>
			</p>
		<?php endforeach; ?>
	</div>
	<?php
}

// Render the rollout custom panel fields used by the rollout page template.
function lp_render_rollout_fields_box(WP_Post $post): void {
	if (!lp_is_rollout_page($post)) {
		echo '<p>These rollout fields are only used by the page with slug <code>rollout-custom-panel</code>.</p>';
		return;
	}

	wp_nonce_field('lp_save_rollout_fields', 'lp_rollout_fields_nonce');
	?>
	<div class="lp-fields">
		<p>Edit the rollout panel copy, CTAs, metrics and repeatable blocks here. Use JSON arrays for stats, proof blocks, timeline steps and screenshot cards.</p>
		<p>Example stats JSON: <code>[{"value":"12","label":"Localized proof screenshots"}]</code></p>
		<?php foreach (lp_rollout_fields() as $key => $field) :
			$value = (string) get_post_meta($post->ID, $key, true);
			$is_json = str_contains($key, '_json') || str_contains($key, '_steps');
			?>
			<p>
				<label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($field['label']); ?></strong></label><br>
				<?php if ($field['type'] === 'textarea') : ?>
					<textarea id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" rows="<?php echo $is_json ? 10 : 3; ?>" style="width:100%;font-family:monospace;"><?php echo esc_textarea($value); ?></textarea>
				<?php else : ?>
					<input id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" type="<?php echo esc_attr($field['type']); ?>" value="<?php echo esc_attr($value); ?>" style="width:100%;">
				<?php endif; ?>
			</p>
		<?php endforeach; ?>
	</div>
	<?php
}

// Render the plugin code page fields so labels and visible file registry are manageable in wp-admin.
function lp_render_plugin_code_fields_box(WP_Post $post): void {
	if (!lp_is_plugin_code_page($post)) {
		echo '<p>These code-page fields are only used by the page with slug <code>plugin-code</code>.</p>';
		return;
	}

	wp_nonce_field('lp_save_plugin_code_fields', 'lp_plugin_code_fields_nonce');
	?>
	<div class="lp-fields">
		<p>Edit the code-page summary cards, API example text, sample code and every visible code panel here. Nothing on this page needs to be loaded live from the server anymore.</p>
		<p>Example summary cards JSON: <code>[{"label":"Toolkit","value":"CPTs, fields, REST"}]</code></p>
		<p>Example panels JSON: <code>[{"eyebrow":"plugins/lago-process-toolkit/lagoprocess-toolkit.php","title":"Lago Process Toolkit Plugin","description":"Registers CPTs and fields.","code":"&lt;?php\nregister_post_type('lp_app', [...]);"}]</code></p>
		<?php foreach (lp_plugin_code_fields() as $key => $field) :
			$value = (string) get_post_meta($post->ID, $key, true);
			$is_large = str_contains($key, 'json') || str_contains($key, '_code') || $key === 'lp_plugin_code_files' || $key === 'lp_plugin_code_summary_cards';
			?>
			<p>
				<label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($field['label']); ?></strong></label><br>
				<?php if ($field['type'] === 'textarea') : ?>
					<textarea id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" rows="<?php echo $is_large ? 10 : 3; ?>" style="width:100%;font-family:monospace;"><?php echo esc_textarea($value); ?></textarea>
				<?php else : ?>
					<input id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" type="<?php echo esc_attr($field['type']); ?>" value="<?php echo esc_attr($value); ?>" style="width:100%;">
				<?php endif; ?>
			</p>
		<?php endforeach; ?>
	</div>
	<?php
}

function lp_render_page_specific_fields_box(WP_Post $post): void {
	$fields = lp_page_fields_for_slug($post->post_name);
	if ($fields === [] || $post->post_name === 'home' || lp_is_rollout_page($post) || lp_is_plugin_code_page($post)) {
		echo '<p>No extra page-specific fields are registered for this page.</p>';
		return;
	}

	wp_nonce_field('lp_save_page_specific_fields', 'lp_page_specific_fields_nonce');
	?>
	<div class="lp-fields">
		<p>These fields control the template-level text for this page while keeping the body content editable in the classic editor.</p>
		<?php foreach ($fields as $key => $field) :
			$value = (string) get_post_meta($post->ID, $key, true);
			$is_large = $field['type'] === 'textarea';
			?>
			<p>
				<label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($field['label']); ?></strong></label><br>
				<?php if ($field['type'] === 'textarea') : ?>
					<textarea id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" rows="<?php echo $is_large ? 8 : 3; ?>" style="width:100%;font-family:monospace;"><?php echo esc_textarea($value); ?></textarea>
				<?php else : ?>
					<input id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" type="<?php echo esc_attr($field['type']); ?>" value="<?php echo esc_attr($value); ?>" style="width:100%;">
				<?php endif; ?>
			</p>
		<?php endforeach; ?>
	</div>
	<?php
}

add_action('admin_enqueue_scripts', function (string $hook): void {
	$screen = get_current_screen();
	if (!$screen instanceof WP_Screen || !lp_is_project_type((string) $screen->post_type)) {
		return;
	}

	wp_enqueue_script(
		'lp-admin-fields',
		plugins_url('assets/js/admin-fields.js', __FILE__),
		[],
		LP_TOOLKIT_VERSION,
		true
	);
});

// Group all portfolio content in one WordPress admin menu for quick screen-share access.
add_action('admin_menu', function (): void {
	add_menu_page(
		'Lago Portfolio',
		'Lago Portfolio',
		'edit_posts',
		'lago-portfolio',
		static function (): void {
			echo '<div class="wrap"><h1>Lago Portfolio</h1><p>Manage projects, served brands, technical fields, project links and temporary access credentials.</p></div>';
		},
		'dashicons-portfolio',
		25
	);

	add_submenu_page(
		'lago-portfolio',
		'Lago Site Settings',
		'Site Settings',
		'edit_theme_options',
		'lago-site-settings',
		'lp_render_site_settings_page'
	);

});

function lp_render_site_settings_page(): void {
	if (!current_user_can('edit_theme_options')) {
		return;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lp_site_settings_nonce']) && wp_verify_nonce((string) $_POST['lp_site_settings_nonce'], 'lp_save_site_settings')) {
		foreach (lp_global_fields() as $key => $field) {
			$value = wp_unslash($_POST[$key] ?? '');
			if ($field['type'] === 'url') {
				update_option($key, esc_url_raw((string) $value));
				continue;
			}

			update_option($key, sanitize_textarea_field((string) $value));
		}

		echo '<div class="notice notice-success"><p>Site settings saved.</p></div>';
	}
	?>
	<div class="wrap">
		<h1>Lago Site Settings</h1>
		<p>These settings control the global header, footer, SEO defaults, archive text and shared labels used across the portfolio.</p>
		<form method="post">
			<?php wp_nonce_field('lp_save_site_settings', 'lp_site_settings_nonce'); ?>
			<table class="form-table" role="presentation">
				<tbody>
				<?php foreach (lp_global_fields() as $key => $field) :
					$value = (string) get_option($key, '');
					?>
					<tr>
						<th scope="row"><label for="<?php echo esc_attr($key); ?>"><?php echo esc_html($field['label']); ?></label></th>
						<td>
							<?php if ($field['type'] === 'textarea') : ?>
								<textarea id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" rows="4" class="large-text code"><?php echo esc_textarea($value); ?></textarea>
							<?php else : ?>
								<input id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" type="<?php echo esc_attr($field['type']); ?>" value="<?php echo esc_attr($value); ?>" class="regular-text">
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php submit_button('Save Site Settings'); ?>
		</form>
	</div>
	<?php
}

// Persist field values with nonces, capability checks and type-aware sanitization.
add_action('save_post', function (int $post_id): void {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (isset($_POST['lp_project_fields_nonce']) && wp_verify_nonce((string) $_POST['lp_project_fields_nonce'], 'lp_save_project_fields')) {
		foreach (lp_acf_like_fields() as $key => $field) {
			if (!isset($_POST[$key])) {
				continue;
			}

			$value = wp_unslash($_POST[$key]);
			if ($field['type'] === 'url') {
				update_post_meta($post_id, $key, esc_url_raw((string) $value));
				continue;
			}

			update_post_meta($post_id, $key, sanitize_textarea_field((string) $value));
		}
	}

	if (isset($_POST['lp_brand_fields_nonce']) && wp_verify_nonce((string) $_POST['lp_brand_fields_nonce'], 'lp_save_brand_fields')) {
		foreach (lp_brand_fields() as $key => $field) {
			if (!isset($_POST[$key])) {
				continue;
			}

			$value = wp_unslash($_POST[$key]);
			if ($field['type'] === 'url') {
				update_post_meta($post_id, $key, esc_url_raw((string) $value));
				continue;
			}

			update_post_meta($post_id, $key, sanitize_textarea_field((string) $value));
		}
	}

	if (isset($_POST['lp_home_fields_nonce']) && wp_verify_nonce((string) $_POST['lp_home_fields_nonce'], 'lp_save_home_fields')) {
		foreach (lp_home_fields() as $key => $field) {
			if (!isset($_POST[$key])) {
				continue;
			}

			$value = wp_unslash($_POST[$key]);
			if ($field['type'] === 'url') {
				update_post_meta($post_id, $key, esc_url_raw((string) $value));
				continue;
			}

			update_post_meta($post_id, $key, sanitize_textarea_field((string) $value));
		}
	}

	if (isset($_POST['lp_rollout_fields_nonce']) && wp_verify_nonce((string) $_POST['lp_rollout_fields_nonce'], 'lp_save_rollout_fields')) {
		foreach (lp_rollout_fields() as $key => $field) {
			if (!isset($_POST[$key])) {
				continue;
			}

			$value = wp_unslash($_POST[$key]);
			if ($field['type'] === 'url') {
				update_post_meta($post_id, $key, esc_url_raw((string) $value));
				continue;
			}

			update_post_meta($post_id, $key, sanitize_textarea_field((string) $value));
		}
	}

	if (isset($_POST['lp_plugin_code_fields_nonce']) && wp_verify_nonce((string) $_POST['lp_plugin_code_fields_nonce'], 'lp_save_plugin_code_fields')) {
		foreach (lp_plugin_code_fields() as $key => $field) {
			if (!isset($_POST[$key])) {
				continue;
			}

			$value = wp_unslash($_POST[$key]);
			if (in_array($key, ['lp_plugin_code_api_code', 'lp_plugin_code_files'], true)) {
				update_post_meta($post_id, $key, (string) $value);
				continue;
			}

			update_post_meta($post_id, $key, sanitize_textarea_field((string) $value));
		}
	}

	if (isset($_POST['lp_page_specific_fields_nonce']) && wp_verify_nonce((string) $_POST['lp_page_specific_fields_nonce'], 'lp_save_page_specific_fields')) {
		$slug = (string) get_post_field('post_name', $post_id);
		foreach (lp_page_fields_for_slug($slug) as $key => $field) {
			if (!isset($_POST[$key])) {
				continue;
			}

			$value = wp_unslash($_POST[$key]);
			if ($field['type'] === 'url') {
				update_post_meta($post_id, $key, esc_url_raw((string) $value));
				continue;
			}

			update_post_meta($post_id, $key, sanitize_textarea_field((string) $value));
		}
	}
});

// Theme helper compatible with the common ACF get_field pattern.
function lp_get_field(string $field_name, ?int $post_id = null) {
	$post_id = $post_id ?: get_the_ID();
	if (!$post_id) {
		return '';
	}

	return get_post_meta($post_id, $field_name, true);
}

// Theme helper compatible with the common ACF the_field pattern.
function lp_the_field(string $field_name, ?int $post_id = null): void {
	echo wp_kses_post((string) lp_get_field($field_name, $post_id));
}

function lp_get_option(string $field_name, string $fallback = ''): string {
	$value = get_option($field_name, '');
	return is_string($value) && $value !== '' ? $value : $fallback;
}

// Decode JSON flexible sections so the theme can render reusable layouts.
function lp_get_flexible_sections(?int $post_id = null): array {
	$raw = (string) lp_get_field('lp_flexible_json', $post_id);
	if ($raw === '') {
		return [];
	}

	$decoded = json_decode($raw, true);
	return is_array($decoded) ? $decoded : [];
}

// Expose custom meta fields in the WordPress REST API for integration proof.
add_action('rest_api_init', function (): void {
	foreach (array_keys(lp_project_types()) as $post_type) {
		foreach (array_keys(lp_acf_like_fields()) as $field_name) {
			register_rest_field($post_type, $field_name, [
				'get_callback' => static fn(array $object) => get_post_meta((int) $object['id'], $field_name, true),
				'schema'       => ['type' => 'string'],
			]);
		}
	}

	foreach (array_keys(lp_brand_type()) as $post_type) {
		foreach (array_keys(lp_brand_fields()) as $field_name) {
			register_rest_field($post_type, $field_name, [
				'get_callback' => static fn(array $object) => get_post_meta((int) $object['id'], $field_name, true),
				'schema'       => ['type' => 'string'],
			]);
		}
	}
});

register_activation_hook(__FILE__, function (): void {
	foreach (lp_project_types() as $post_type => $config) {
		register_post_type($post_type, [
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => ['slug' => $config['slug']],
		]);
	}

	foreach (lp_brand_type() as $post_type => $config) {
		register_post_type($post_type, [
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => ['slug' => $config['slug']],
		]);
	}
	flush_rewrite_rules();
});

register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
