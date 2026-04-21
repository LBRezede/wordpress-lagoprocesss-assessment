(() => {
	const header = document.querySelector('.site-header');
	const toggle = document.querySelector('.menu-toggle');
	const nav = document.querySelector('#site-navigation');

	if (!header || !toggle || !nav) {
		return;
	}

	const closeMenu = () => {
		header.classList.remove('is-menu-open');
		toggle.setAttribute('aria-expanded', 'false');
	};

	const openMenu = () => {
		header.classList.add('is-menu-open');
		toggle.setAttribute('aria-expanded', 'true');
	};

	toggle.addEventListener('click', () => {
		if (header.classList.contains('is-menu-open')) {
			closeMenu();
			return;
		}

		openMenu();
	});

	nav.addEventListener('click', (event) => {
		const target = event.target;
		if (target instanceof HTMLAnchorElement && target.getAttribute('href') !== '#') {
			closeMenu();
		}
	});

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape') {
			closeMenu();
		}
	});

	document.addEventListener('click', (event) => {
		if (!(event.target instanceof Node) || header.contains(event.target)) {
			return;
		}

		closeMenu();
	});
})();
