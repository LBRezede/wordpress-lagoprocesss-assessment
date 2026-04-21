	</main>
	<footer class="site-footer">
		<p><?php echo esc_html(lago_site_setting('lp_footer_text', 'Custom WordPress theme, CPTs, ACF-like fields, REST-ready metadata, and runtime optimization mu-plugin.')); ?></p>
		<a href="<?php echo esc_url(home_url('/sitemap.xml')); ?>"><?php echo esc_html(lago_site_setting('lp_footer_link_label', 'Sitemap XML')); ?></a>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>
