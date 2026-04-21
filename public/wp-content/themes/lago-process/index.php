<?php
declare(strict_types=1);

get_header();
?>
<section class="archive-intro">
	<p class="eyebrow"><?php echo is_archive() ? esc_html(post_type_archive_title('', false)) : 'Latest'; ?></p>
	<h1><?php echo is_archive() ? esc_html(post_type_archive_title('', false)) : esc_html(get_bloginfo('name')); ?></h1>
</section>
<div class="content-list">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<article class="list-card">
				<p class="project-type"><?php echo esc_html(lago_project_type_label()); ?></p>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<p><?php echo esc_html(get_the_excerpt()); ?></p>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p>No content found.</p>
	<?php endif; ?>
</div>
<?php
get_footer();
