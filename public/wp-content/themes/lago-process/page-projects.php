<?php
declare(strict_types=1);

get_header();
$project_query = new WP_Query(lago_project_query_args(20));
?>
<article class="directory-page">
	<header class="directory-hero">
		<p class="eyebrow"><?php echo esc_html(lago_page_field('lp_projects_eyebrow', 'Project Index')); ?></p>
		<h1><?php the_title(); ?></h1>
		<p><?php echo esc_html(lago_page_field('lp_projects_lede', 'Published project pages with documentation, system access, technology stack, integrated APIs and visual context.')); ?></p>
	</header>

	<section class="project-directory-grid">
		<?php if ($project_query->have_posts()) : ?>
			<?php while ($project_query->have_posts()) : $project_query->the_post(); ?>
				<article class="directory-card">
					<a class="project-thumb" href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url(lago_project_visual_uri()); ?>" width="1200" height="760" loading="lazy" decoding="async" alt="<?php echo esc_attr(get_the_title()); ?> visual">
					</a>
					<p class="project-type"><?php echo esc_html(lago_project_type_label()); ?></p>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p><?php echo esc_html(lago_field('lp_project_summary') ?: get_the_excerpt()); ?></p>
					<div class="directory-meta">
						<span><?php echo esc_html(lago_page_field('lp_projects_stack_label', 'Stack')); ?></span>
						<strong><?php echo esc_html(lago_field('lp_stack')); ?></strong>
					</div>
					<a class="button ghost" href="<?php the_permalink(); ?>"><?php echo esc_html(lago_page_field('lp_projects_button_label', 'Open project page')); ?></a>
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		<?php endif; ?>
	</section>
</article>
<?php
get_footer();
