<?php
declare(strict_types=1);

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
	<article class="single-project" style="--accent: <?php echo esc_attr(lago_project_accent()); ?>">
		<header class="single-hero project-detail-hero">
			<div>
				<p class="eyebrow"><?php echo esc_html(lago_project_type_label()); ?></p>
				<h1><?php the_title(); ?></h1>
				<p><?php echo esc_html(lago_field('lp_project_summary') ?: get_the_excerpt()); ?></p>
			</div>
			<figure class="project-hero-image">
				<img src="<?php echo esc_url(lago_project_visual_uri()); ?>" width="1200" height="760" loading="eager" decoding="async" alt="<?php echo esc_attr(get_the_title()); ?> project visual">
			</figure>
		</header>

		<section class="case-meta">
			<div><span><?php echo esc_html(lago_site_setting('lp_single_client_label', 'Client type')); ?></span><strong><?php echo esc_html(lago_field('lp_client_type')); ?></strong></div>
			<div><span><?php echo esc_html(lago_site_setting('lp_single_source_label', 'Source')); ?></span><strong><?php echo esc_html(lago_field('lp_source_path')); ?></strong></div>
			<div><span><?php echo esc_html(lago_site_setting('lp_single_demo_label', 'Demo')); ?></span><strong>
				<?php $demo_url = lago_field('lp_demo_url'); ?>
				<?php if ($demo_url) : ?><a href="<?php echo esc_url($demo_url); ?>"><?php echo esc_html(lago_site_setting('lp_single_demo_link_label', 'View link')); ?></a><?php else : ?><?php echo esc_html(lago_site_setting('lp_single_private_label', 'Private/internal')); ?><?php endif; ?>
			</strong></div>
		</section>

		<section class="access-panel">
			<div>
				<p class="eyebrow"><?php echo esc_html(lago_site_setting('lp_single_access_eyebrow', 'Temporary Access')); ?></p>
				<h2><?php echo esc_html(lago_site_setting('lp_single_access_title', 'Project link and demo credentials')); ?></h2>
				<p><?php echo esc_html(lago_site_setting('lp_single_access_body', 'These details are editable in WordPress for each CPT and are meant for controlled assessment review.')); ?></p>
			</div>
			<div class="credential-card">
				<?php $project_url = lago_field('lp_project_url') ?: lago_field('lp_demo_url'); ?>
				<?php $access_url = lago_field('lp_access_url') ?: $project_url; ?>
				<dl>
					<dt><?php echo esc_html(lago_site_setting('lp_single_project_label', 'Project')); ?></dt>
					<dd><?php if ($project_url) : ?><a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($project_url); ?></a><?php else : ?><?php echo esc_html(lago_site_setting('lp_single_not_provided_label', 'Not provided')); ?><?php endif; ?></dd>
					<dt><?php echo esc_html(lago_site_setting('lp_single_login_label', 'Login')); ?></dt>
					<dd><?php if ($access_url) : ?><a href="<?php echo esc_url($access_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($access_url); ?></a><?php else : ?><?php echo esc_html(lago_site_setting('lp_single_not_provided_label', 'Not provided')); ?><?php endif; ?></dd>
					<dt><?php echo esc_html(lago_site_setting('lp_single_user_label', 'User')); ?></dt>
					<dd><code><?php echo esc_html(lago_field('lp_demo_user') ?: lago_site_setting('lp_single_user_fallback', 'provided on request')); ?></code></dd>
					<dt><?php echo esc_html(lago_site_setting('lp_single_password_label', 'Password')); ?></dt>
					<dd><code><?php echo esc_html(lago_field('lp_demo_password') ?: lago_site_setting('lp_single_password_fallback', 'provided on request')); ?></code></dd>
				</dl>
				<?php if (lago_field('lp_access_notes')) : ?>
					<p><?php echo nl2br(esc_html(lago_field('lp_access_notes'))); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<section class="technical-grid">
			<div class="tech-panel">
				<h2><?php echo esc_html(lago_site_setting('lp_single_stack_title', 'Technology Stack')); ?></h2>
				<ul class="check-list">
					<?php foreach (lago_field_lines('lp_stack_used') as $item) : ?>
						<li><?php echo esc_html($item); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="tech-panel dark">
				<h2><?php echo esc_html(lago_site_setting('lp_single_integrated_apis_title', 'Integrated APIs')); ?></h2>
				<ul class="check-list">
					<?php foreach (lago_field_lines('lp_integrated_apis') as $item) : ?>
						<li><?php echo esc_html($item); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="tech-panel">
				<h2><?php echo esc_html(lago_site_setting('lp_single_admin_features_title', 'Admin features')); ?></h2>
				<p><?php echo nl2br(esc_html(lago_field('lp_admin_features'))); ?></p>
			</div>
		</section>

		<div class="case-body">
			<div>
				<h2><?php echo esc_html(lago_site_setting('lp_single_documentation_title', 'Project Documentation')); ?></h2>
				<?php the_content(); ?>
				<h2><?php echo esc_html(lago_site_setting('lp_single_code_evidence_title', 'Server code evidence')); ?></h2>
				<p><?php echo nl2br(esc_html(lago_field('lp_code_evidence'))); ?></p>
			</div>
			<aside>
				<h2><?php echo esc_html(lago_site_setting('lp_single_integrations_title', 'Integrations')); ?></h2>
				<p><?php echo nl2br(esc_html(lago_field('lp_integrations'))); ?></p>
				<h2><?php echo esc_html(lago_site_setting('lp_single_automation_title', 'Automation flow')); ?></h2>
				<p><?php echo nl2br(esc_html(lago_field('lp_automation_flow'))); ?></p>
				<h2><?php echo esc_html(lago_site_setting('lp_single_outcome_title', 'Outcome')); ?></h2>
				<p><?php echo nl2br(esc_html(lago_field('lp_results'))); ?></p>
			</aside>
		</div>

		<?php lago_render_flexible_sections(get_the_ID()); ?>
	</article>
<?php endwhile; ?>
<?php
get_footer();
