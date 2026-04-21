<?php
declare(strict_types=1);

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
	<article class="page-content schedule-page">
		<p class="eyebrow"><?php echo esc_html(lago_page_field('lp_schedule_eyebrow', 'Next Step')); ?></p>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
		<div class="schedule-card">
			<div>
				<h2><?php echo esc_html(lago_page_field('lp_schedule_card_title', 'Book a follow-up review')); ?></h2>
				<p><?php echo esc_html(lago_page_field('lp_schedule_card_body', 'Use the FusionCore scheduler to choose a time for the next conversation and walk through the WordPress build, integrations, project credentials and deployment evidence.')); ?></p>
			</div>
			<a class="button primary" href="<?php echo esc_url(lago_page_field('lp_schedule_button_url', 'https://app.fusioncore.com.br/public/agendador')); ?>" target="_blank" rel="noopener"><?php echo esc_html(lago_page_field('lp_schedule_button_label', 'Open Scheduling Page')); ?></a>
		</div>
	</article>
<?php endwhile; ?>
<?php
get_footer();
