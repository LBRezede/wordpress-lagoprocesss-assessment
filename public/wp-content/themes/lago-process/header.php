<?php
declare(strict_types=1);
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content"><?php esc_html_e('Skip to content', 'lago-process'); ?></a>
<header class="site-header">
	<div class="site-header-inner">
		<a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?>">
			<span class="brand-mark">LB</span>
			<span>
				<strong><?php bloginfo('name'); ?></strong>
				<em>Portfolio and Showcase</em>
			</span>
		</a>
		<button class="menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false">
			<span></span>
			<span></span>
			<span></span>
			<strong>Menu</strong>
		</button>
		<nav id="site-navigation" class="main-nav" aria-label="<?php esc_attr_e('Primary navigation', 'lago-process'); ?>">
			<?php
			wp_nav_menu([
				'theme_location' => 'primary',
				'container'      => false,
				'fallback_cb'    => false,
				'depth'          => 2,
			]);
			?>
			<a class="nav-cta" href="<?php echo esc_url(home_url('/schedule-next-step/')); ?>">Schedule</a>
		</nav>
	</div>
</header>
<main id="content" class="site-main">
