<?php
declare(strict_types=1);

function lago_plugin_code_field(string $key, string $fallback = ''): string {
	$value = (string) get_post_meta(get_the_ID(), $key, true);
	return $value !== '' ? $value : $fallback;
}

function lago_plugin_code_blocks(string $key, array $fallback = []): array {
	$raw = (string) get_post_meta(get_the_ID(), $key, true);
	if ($raw === '') {
		return $fallback;
	}

	$decoded = json_decode($raw, true);
	return is_array($decoded) ? $decoded : $fallback;
}

$default_toolkit_code = <<<'PHP'
<?php
declare(strict_types=1);

add_filter('use_block_editor_for_post', '__return_false', 100);
add_filter('use_block_editor_for_post_type', '__return_false', 100);

function lp_project_types(): array {
    return [
        'lp_delivery' => ['singular' => 'Delivery Project', 'slug' => 'delivery'],
        'lp_app' => ['singular' => 'App Project', 'slug' => 'apps'],
        'lp_pms' => ['singular' => 'PMS Project', 'slug' => 'pms'],
        'lp_crm' => ['singular' => 'CRM Project', 'slug' => 'crm'],
        'lp_fusion_ai' => ['singular' => 'Fusion AI Project', 'slug' => 'fusion-ai'],
    ];
}

function lp_plugin_code_fields(): array {
    return [
        'lp_plugin_code_summary_cards' => ['label' => 'Summary cards JSON', 'type' => 'textarea'],
        'lp_plugin_code_api_code' => ['label' => 'API example code', 'type' => 'textarea'],
        'lp_plugin_code_files' => ['label' => 'Code panels JSON', 'type' => 'textarea'],
    ];
}
PHP;

$default_runtime_code = <<<'PHP'
<?php
declare(strict_types=1);

add_action('template_redirect', static function (): void {
    if (is_admin() || wp_doing_ajax()) {
        return;
    }

    header_remove('X-Pingback');
}, 1);

add_filter('script_loader_tag', static function (string $tag, string $handle): string {
    $delayed = ['google-analytics', 'gtag', 'facebook-pixel'];
    if (!in_array($handle, $delayed, true)) {
        return $tag;
    }

    return str_replace('<script ', '<script data-lago-delay="1" ', $tag);
}, 10, 2);
PHP;

$default_cache_code = <<<'PHP'
<?php
declare(strict_types=1);

function lago_page_cache_should_bypass(): bool {
    if (is_user_logged_in() || wp_doing_ajax()) {
        return true;
    }

    return $_SERVER['REQUEST_METHOD'] !== 'GET';
}

add_action('save_post', static function (): void {
    lago_page_cache_purge_all();
});
PHP;

$plugin_files = lago_plugin_code_blocks('lp_plugin_code_files', [
	[
		'eyebrow' => 'plugins/lago-process-toolkit/lagoprocess-toolkit.php',
		'title' => 'Lago Process Toolkit Plugin',
		'description' => 'Registers portfolio custom post types, admin menu entries, ACF-like fields, classic editor behavior, REST fields and the editable page field layers.',
		'code' => $default_toolkit_code,
	],
	[
		'eyebrow' => 'mu-plugins/lago-runtime-optimization.php',
		'title' => 'Lago Runtime Optimization MU Plugin',
		'description' => 'Runs automatically as a must-use plugin and handles conservative performance optimizations, delayed trackers, image dimensions, sitemap output and vendor request hardening.',
		'code' => $default_runtime_code,
	],
	[
		'eyebrow' => 'mu-plugins/lago-page-cache.php',
		'title' => 'Lago Page Cache MU Plugin',
		'description' => 'Runs automatically as a must-use plugin and provides a small full-page cache for anonymous visitors with safe bypass and invalidation rules.',
		'code' => $default_cache_code,
	],
]);

$summary_cards = lago_plugin_code_blocks('lp_plugin_code_summary_cards', [
	['label' => 'Toolkit', 'value' => 'CPTs, fields, REST'],
	['label' => 'MU Runtime', 'value' => 'Optimization layer'],
	['label' => 'MU Cache', 'value' => 'Anonymous page cache'],
	['label' => 'API Example', 'value' => 'Google Calendar'],
]);

$google_calendar_example = lago_plugin_code_field('lp_plugin_code_api_code', <<<'PHP'
<?php
declare(strict_types=1);

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

// Credentials should be injected from environment variables or a secret manager.
$client = new Client();
$client->setApplicationName('Lucas Bacellar Portfolio Scheduler');
$client->setAuthConfig([
    'type' => 'service_account',
    'client_email' => getenv('GOOGLE_CLIENT_EMAIL'),
    'private_key' => str_replace('\\n', "\n", (string) getenv('GOOGLE_PRIVATE_KEY')),
]);
$client->addScope(Calendar::CALENDAR_EVENTS);

$calendar = new Calendar($client);
$calendarId = getenv('GOOGLE_CALENDAR_ID') ?: 'primary';

// The event payload can be generated from a WordPress form, CRM lead or Zapier webhook.
$event = new Event([
    'summary' => 'Portfolio follow-up call',
    'description' => 'Assessment follow-up scheduled from the Lucas Bacellar portfolio.',
    'start' => [
        'dateTime' => '2026-04-24T10:00:00-04:00',
        'timeZone' => 'America/New_York',
    ],
    'end' => [
        'dateTime' => '2026-04-24T10:30:00-04:00',
        'timeZone' => 'America/New_York',
    ],
    'attendees' => [
        ['email' => 'reviewer@example.com'],
    ],
    'conferenceData' => [
        'createRequest' => [
            'requestId' => bin2hex(random_bytes(12)),
            'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
        ],
    ],
]);

$createdEvent = $calendar->events->insert($calendarId, $event, [
    'conferenceDataVersion' => 1,
    'sendUpdates' => 'all',
]);

echo $createdEvent->getHtmlLink();
PHP);

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
	<article class="plugin-code-page">
		<header class="doc-hero">
			<p class="eyebrow"><?php echo esc_html(lago_plugin_code_field('lp_plugin_code_hero_eyebrow', 'Code Evidence')); ?></p>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</header>

		<section class="code-summary-grid">
			<?php foreach ($summary_cards as $card) : ?>
				<?php if (!is_array($card)) { continue; } ?>
				<div>
					<span><?php echo esc_html((string) ($card['label'] ?? 'Code')); ?></span>
					<strong><?php echo esc_html((string) ($card['value'] ?? '')); ?></strong>
				</div>
			<?php endforeach; ?>
		</section>

		<section class="api-evidence-panel">
			<div>
				<p class="eyebrow"><?php echo esc_html(lago_plugin_code_field('lp_plugin_code_api_eyebrow', 'API Integration Pattern')); ?></p>
				<h2><?php echo esc_html(lago_plugin_code_field('lp_plugin_code_api_title', 'Google Calendar scheduling example')); ?></h2>
				<p><?php echo esc_html(lago_plugin_code_field('lp_plugin_code_api_body', 'This example shows how the scheduler or CRM layer can create a Calendar event with Google Meet. Secrets are represented by environment variables only; no private key or token is printed on this page.')); ?></p>
			</div>
			<pre><code><?php echo esc_html($google_calendar_example); ?></code></pre>
		</section>

		<?php foreach ($plugin_files as $file) : ?>
			<?php if (!is_array($file)) { continue; } ?>
			<section class="code-file-panel">
				<div class="code-file-intro">
					<p class="eyebrow"><?php echo esc_html((string) ($file['eyebrow'] ?? 'Code panel')); ?></p>
					<h2><?php echo esc_html((string) ($file['title'] ?? 'Code example')); ?></h2>
					<p><?php echo esc_html((string) ($file['description'] ?? '')); ?></p>
				</div>
				<pre><code><?php echo esc_html((string) ($file['code'] ?? 'Code not provided.')); ?></code></pre>
			</section>
		<?php endforeach; ?>
	</article>
<?php endwhile; ?>
<?php
get_footer();
