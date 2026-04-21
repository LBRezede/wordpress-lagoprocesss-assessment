<?php
declare(strict_types=1);

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
	<article class="page-content versioning-page">
		<p class="eyebrow">Deployment Evidence</p>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>

		<section class="version-grid">
			<article>
				<span>01</span>
				<h2>Docker-ready project</h2>
				<p>The subdomain has a dedicated Docker Compose file for local review of the WordPress stack without touching the other applications on this server.</p>
				<code>lagoprocess/docker-compose.yml</code>
			</article>
			<article>
				<span>02</span>
				<h2>Git versioning scope</h2>
				<p>The repository scope is limited to the portfolio assets: theme, plugin, mu-plugins, Docker files and documentation. WordPress core, uploads, cache and secrets are ignored.</p>
				<code>lagoprocess/.gitignore</code>
			</article>
			<article>
				<span>03</span>
				<h2>GitHub publication</h2>
				<p>The server does not have GitHub CLI installed. The project is prepared for a new GitHub repository using the commands below after adding remote credentials.</p>
				<code>git remote add origin git@github.com:USER/lucas-bacellar-portfolio-showcase.git</code>
			</article>
		</section>

		<section class="command-panel">
			<h2>Repository commands</h2>
			<pre><code>cd /var/www/app.fusioncore.com.br/lagoprocess
git init
git add README.md docker-compose.yml .gitignore public/wp-content/themes/lago-process public/wp-content/plugins/lago-process-toolkit public/wp-content/mu-plugins
git commit -m "Initial Lucas Bacellar portfolio showcase"
git branch -M main
git remote add origin git@github.com:YOUR_USER/lucas-bacellar-portfolio-showcase.git
git push -u origin main</code></pre>
		</section>
	</article>
<?php endwhile; ?>
<?php
get_footer();
