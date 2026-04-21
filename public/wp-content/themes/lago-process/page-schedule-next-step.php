<?php
declare(strict_types=1);

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
	<article class="page-content schedule-page">
		<p class="eyebrow">Next Step</p>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
		<div class="schedule-card">
			<div>
				<h2>Book a follow-up review</h2>
				<p>Use the FusionCore scheduler to choose a time for the next conversation and walk through the WordPress build, integrations, project credentials and deployment evidence.</p>
			</div>
			<a class="button primary" href="https://app.fusioncore.com.br/public/agendador" target="_blank" rel="noopener">Open Scheduling Page</a>
		</div>
	</article>
<?php endwhile; ?>
<?php
get_footer();
