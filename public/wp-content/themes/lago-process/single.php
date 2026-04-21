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
			<div><span>Client type</span><strong><?php echo esc_html(lago_field('lp_client_type')); ?></strong></div>
			<div><span>Source</span><strong><?php echo esc_html(lago_field('lp_source_path')); ?></strong></div>
			<div><span>Demo</span><strong>
				<?php $demo_url = lago_field('lp_demo_url'); ?>
				<?php if ($demo_url) : ?><a href="<?php echo esc_url($demo_url); ?>">View link</a><?php else : ?>Private/internal<?php endif; ?>
			</strong></div>
		</section>

		<section class="access-panel">
			<div>
				<p class="eyebrow">Temporary Access</p>
				<h2>Project link and demo credentials</h2>
				<p>These details are editable in WordPress for each CPT and are meant for controlled assessment review.</p>
			</div>
			<div class="credential-card">
				<?php $project_url = lago_field('lp_project_url') ?: lago_field('lp_demo_url'); ?>
				<?php $access_url = lago_field('lp_access_url') ?: $project_url; ?>
				<dl>
					<dt>Project</dt>
					<dd><?php if ($project_url) : ?><a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($project_url); ?></a><?php else : ?>Not provided<?php endif; ?></dd>
					<dt>Login</dt>
					<dd><?php if ($access_url) : ?><a href="<?php echo esc_url($access_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($access_url); ?></a><?php else : ?>Not provided<?php endif; ?></dd>
					<dt>User</dt>
					<dd><code><?php echo esc_html(lago_field('lp_demo_user') ?: 'provided on request'); ?></code></dd>
					<dt>Password</dt>
					<dd><code><?php echo esc_html(lago_field('lp_demo_password') ?: 'provided on request'); ?></code></dd>
				</dl>
				<?php if (lago_field('lp_access_notes')) : ?>
					<p><?php echo nl2br(esc_html(lago_field('lp_access_notes'))); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<section class="technical-grid">
			<div class="tech-panel">
				<h2>Technology Stack</h2>
				<ul class="check-list">
					<?php foreach (lago_field_lines('lp_stack_used') as $item) : ?>
						<li><?php echo esc_html($item); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="tech-panel dark">
				<h2>Integrated APIs</h2>
				<ul class="check-list">
					<?php foreach (lago_field_lines('lp_integrated_apis') as $item) : ?>
						<li><?php echo esc_html($item); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="tech-panel">
				<h2>Admin features</h2>
				<p><?php echo nl2br(esc_html(lago_field('lp_admin_features'))); ?></p>
			</div>
		</section>

		<div class="case-body">
			<div>
				<h2>Project Documentation</h2>
				<?php the_content(); ?>
				<h2>Server code evidence</h2>
				<p><?php echo nl2br(esc_html(lago_field('lp_code_evidence'))); ?></p>
			</div>
			<aside>
				<h2>Integrations</h2>
				<p><?php echo nl2br(esc_html(lago_field('lp_integrations'))); ?></p>
				<h2>Automation flow</h2>
				<p><?php echo nl2br(esc_html(lago_field('lp_automation_flow'))); ?></p>
				<h2>Outcome</h2>
				<p><?php echo nl2br(esc_html(lago_field('lp_results'))); ?></p>
			</aside>
		</div>

		<?php lago_render_flexible_sections(get_the_ID()); ?>
	</article>
<?php endwhile; ?>
<?php
get_footer();
