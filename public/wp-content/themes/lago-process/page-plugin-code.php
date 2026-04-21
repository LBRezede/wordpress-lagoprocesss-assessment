<?php
declare(strict_types=1);

function lago_plugin_code_read(string $relative_path): string {
	$base = WP_CONTENT_DIR;
	$full_path = wp_normalize_path($base . '/' . ltrim($relative_path, '/'));

	if (!str_starts_with($full_path, wp_normalize_path($base)) || !is_file($full_path)) {
		return 'File not found.';
	}

	return (string) file_get_contents($full_path);
}

$plugin_files = [
	[
		'title' => 'Lago Process Toolkit Plugin',
		'path' => 'plugins/lago-process-toolkit/lagoprocess-toolkit.php',
		'description' => 'Registers portfolio custom post types, admin menu entries, ACF-like fields, classic editor behavior, REST fields and the editable homepage field layer.',
	],
	[
		'title' => 'Lago Runtime Optimization MU Plugin',
		'path' => 'mu-plugins/lago-runtime-optimization.php',
		'description' => 'Runs automatically as a must-use plugin and handles conservative performance optimizations, delayed trackers, image dimensions, sitemap output and vendor request hardening.',
	],
	[
		'title' => 'Lago Page Cache MU Plugin',
		'path' => 'mu-plugins/lago-page-cache.php',
		'description' => 'Runs automatically as a must-use plugin and provides a small full-page cache for anonymous visitors with safe bypass and invalidation rules.',
	],
];

$google_calendar_example = <<<'PHP'
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
PHP;

get_header();
?>
<?php while (have_posts()) : the_post(); ?>
	<article class="plugin-code-page">
		<header class="doc-hero">
			<p class="eyebrow">Code Evidence</p>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</header>

		<section class="code-summary-grid">
			<div><span>Toolkit</span><strong>CPTs, fields, REST</strong></div>
			<div><span>MU Runtime</span><strong>Optimization layer</strong></div>
			<div><span>MU Cache</span><strong>Anonymous page cache</strong></div>
			<div><span>API Example</span><strong>Google Calendar</strong></div>
		</section>

		<section class="api-evidence-panel">
			<div>
				<p class="eyebrow">API Integration Pattern</p>
				<h2>Google Calendar scheduling example</h2>
				<p>This example shows how the scheduler or CRM layer can create a Calendar event with Google Meet. Secrets are represented by environment variables only; no private key or token is printed on this page.</p>
			</div>
			<pre><code><?php echo esc_html($google_calendar_example); ?></code></pre>
		</section>

		<?php foreach ($plugin_files as $file) : ?>
			<section class="code-file-panel">
				<div class="code-file-intro">
					<p class="eyebrow"><?php echo esc_html($file['path']); ?></p>
					<h2><?php echo esc_html($file['title']); ?></h2>
					<p><?php echo esc_html($file['description']); ?></p>
				</div>
				<pre><code><?php echo esc_html(lago_plugin_code_read((string) $file['path'])); ?></code></pre>
			</section>
		<?php endforeach; ?>
	</article>
<?php endwhile; ?>
<?php
get_footer();
