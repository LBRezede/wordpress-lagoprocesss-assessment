<?php
declare(strict_types=1);

$zapier_result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lp_zapier_nonce']) && wp_verify_nonce((string) $_POST['lp_zapier_nonce'], 'lp_zapier_test')) {
	$webhook_url = esc_url_raw((string) wp_unslash($_POST['webhook_url'] ?? ''));
	$api_key = sanitize_text_field((string) wp_unslash($_POST['api_key'] ?? ''));
	$test_email = sanitize_email((string) wp_unslash($_POST['test_email'] ?? ''));
	$test_name = sanitize_text_field((string) wp_unslash($_POST['test_name'] ?? 'Lucas Bacellar Portfolio Test'));

	if ($webhook_url === '' || !wp_http_validate_url($webhook_url)) {
		$zapier_result = ['ok' => false, 'message' => 'Enter a valid Zapier webhook URL.'];
	} else {
		$headers = ['Content-Type' => 'application/json'];
		if ($api_key !== '') {
			$headers['Authorization'] = 'Bearer ' . $api_key;
		}

		$response = wp_remote_post($webhook_url, [
			'timeout' => 15,
			'headers' => $headers,
			'body' => wp_json_encode([
				'source' => 'Lucas Bacellar Portfolio',
				'event' => 'zapier_assessment_test',
				'name' => $test_name,
				'email' => $test_email,
				'site' => home_url('/'),
				'timestamp' => gmdate('c'),
			]),
		]);

		if (is_wp_error($response)) {
			$zapier_result = ['ok' => false, 'message' => $response->get_error_message()];
		} else {
			$zapier_result = [
				'ok' => true,
				'message' => 'Zapier webhook executed.',
				'code' => (int) wp_remote_retrieve_response_code($response),
				'body' => substr((string) wp_remote_retrieve_body($response), 0, 600),
			];
		}
	}
}

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
	<article class="page-content integration-page">
		<p class="eyebrow">Marketing Automation</p>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>

		<section class="integration-panel">
			<div>
				<h2>Run a Zapier webhook test</h2>
				<p>Paste a Zapier Catch Hook URL and optional bearer token. Credentials are used only for this request and are not stored in WordPress.</p>
			</div>
			<form method="post" class="integration-form">
				<?php wp_nonce_field('lp_zapier_test', 'lp_zapier_nonce'); ?>
				<label>
					<span>Zapier webhook URL</span>
					<input type="url" name="webhook_url" placeholder="https://hooks.zapier.com/hooks/catch/..." required>
				</label>
				<label>
					<span>Optional bearer token / API key</span>
					<input type="password" name="api_key" autocomplete="off" placeholder="Only sent as Authorization header">
				</label>
				<label>
					<span>Test name</span>
					<input type="text" name="test_name" value="Lucas Bacellar Portfolio Test">
				</label>
				<label>
					<span>Test email</span>
					<input type="email" name="test_email" placeholder="reviewer@example.com">
				</label>
				<button class="button primary" type="submit">Execute Zapier Test</button>
			</form>
		</section>

		<?php if (is_array($zapier_result)) : ?>
			<section class="integration-result <?php echo $zapier_result['ok'] ? 'is-success' : 'is-error'; ?>">
				<strong><?php echo esc_html((string) $zapier_result['message']); ?></strong>
				<?php if (isset($zapier_result['code'])) : ?>
					<p>HTTP status: <?php echo esc_html((string) $zapier_result['code']); ?></p>
				<?php endif; ?>
				<?php if (!empty($zapier_result['body'])) : ?>
					<pre><?php echo esc_html((string) $zapier_result['body']); ?></pre>
				<?php endif; ?>
			</section>
		<?php endif; ?>
	</article>
<?php endwhile; ?>
<?php
get_footer();
