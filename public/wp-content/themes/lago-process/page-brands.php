<?php
declare(strict_types=1);

get_header();
$brand_query = new WP_Query(lago_brand_query_args(30));
?>
<article class="directory-page">
	<header class="directory-hero">
		<p class="eyebrow">Served Brands</p>
		<h1><?php the_title(); ?></h1>
		<p>Hospitality brands and operations connected to Lucas Bacellar's WordPress, marketing and systems work. All listed websites were built with WordPress and Elementor Pro.</p>
	</header>

	<section class="brand-grid standalone">
		<?php if ($brand_query->have_posts()) : ?>
			<?php while ($brand_query->have_posts()) : $brand_query->the_post(); ?>
				<article class="brand-card">
					<span><?php echo esc_html(mb_substr(get_the_title(), 0, 2)); ?></span>
					<h3><?php the_title(); ?></h3>
					<p><?php echo esc_html(get_post_meta(get_the_ID(), 'lp_brand_scope', true)); ?></p>
					<p class="brand-stack"><strong>Built with:</strong> WordPress + Elementor Pro</p>
					<?php $brand_url = (string) get_post_meta(get_the_ID(), 'lp_brand_url', true); ?>
					<?php if ($brand_url) : ?>
						<a href="<?php echo esc_url($brand_url); ?>" target="_blank" rel="noopener">Visit website</a>
					<?php endif; ?>
				</article>
			<?php endwhile; wp_reset_postdata(); ?>
		<?php endif; ?>
	</section>
</article>
<?php
get_footer();
