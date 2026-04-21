(function () {
	var button = document.getElementById('lp-insert-flexible-example');
	var target = document.getElementById('lp_flexible_json');

	if (!button || !target) {
		return;
	}

	button.addEventListener('click', function () {
		target.value = JSON.stringify([
			{
				"layout": "hero",
				"eyebrow": "Custom WordPress build",
				"headline": "ACF-style flexible content without a page builder",
				"body": "Structured fields drive the layout, content model, REST output, and case-study templates."
			},
			{
				"layout": "metric_grid",
				"items": [
					{"label": "Automations", "value": "12+"},
					{"label": "Integrations", "value": "CRM / Ads / Webhooks"},
					{"label": "Build style", "value": "Theme + CPT + fields"}
				]
			}
		], null, 2);
	});
})();
