<?php
declare(strict_types=1);

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
	<?php $version_cards = lago_decode_json_blocks(lago_page_field('lp_versioning_cards'), [
		['number' => '01', 'title' => 'Docker-ready project', 'body' => 'The subdomain has a dedicated Docker Compose file for local review of the WordPress stack without touching the other applications on this server.', 'code' => 'lagoprocess/docker-compose.yml'],
		['number' => '02', 'title' => 'Git versioning scope', 'body' => 'The repository scope is limited to the portfolio assets: theme, plugin, mu-plugins, Docker files and documentation. WordPress core, uploads, cache and secrets are ignored.', 'code' => 'lagoprocess/.gitignore'],
		['number' => '03', 'title' => 'GitHub publication', 'body' => 'The server does not have GitHub CLI installed. The project is prepared for a new GitHub repository using the commands below after adding remote credentials.', 'code' => 'git remote add origin git@github.com:USER/lucas-bacellar-portfolio-showcase.git'],
	]); ?>
	<article class="page-content versioning-page">
		<p class="eyebrow"><?php echo esc_html(lago_page_field('lp_versioning_eyebrow', 'Deployment Evidence')); ?></p>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>

		<section class="version-grid">
			<?php foreach ($version_cards as $card) : ?>
				<?php if (!is_array($card)) { continue; } ?>
				<article>
					<span><?php echo esc_html((string) ($card['number'] ?? '')); ?></span>
					<h2><?php echo esc_html((string) ($card['title'] ?? '')); ?></h2>
					<p><?php echo esc_html((string) ($card['body'] ?? '')); ?></p>
					<code><?php echo esc_html((string) ($card['code'] ?? '')); ?></code>
				</article>
			<?php endforeach; ?>
		</section>

		<section class="command-panel">
			<h2><?php echo esc_html(lago_page_field('lp_versioning_commands_title', 'Repository commands')); ?></h2>
			<pre><code><?php echo esc_html(lago_page_field('lp_versioning_commands_code', 'cd /var/www/app.fusioncore.com.br/lagoprocess
git init
git add README.md docker-compose.yml .gitignore public/wp-content/themes/lago-process public/wp-content/plugins/lago-process-toolkit public/wp-content/mu-plugins
git commit -m "Initial Lucas Bacellar portfolio showcase"
git branch -M main
git remote add origin git@github.com:YOUR_USER/lucas-bacellar-portfolio-showcase.git
git push -u origin main')); ?></code></pre>
		</section>
	</article>
<?php endwhile; ?>
<?php
get_footer();
