/**
 * Platform detail modals.
 */
(function () {
	const openers = document.querySelectorAll('[data-platform-open]');

	if (!openers.length || typeof HTMLDialogElement === 'undefined') {
		return;
	}

	let lastFocus = null;

	function openModal(id, trigger) {
		const dialog = document.getElementById(id);

		if (!dialog || typeof dialog.showModal !== 'function' || dialog.open) {
			return;
		}

		lastFocus = trigger;
		dialog.showModal();
	}

	openers.forEach(function (button) {
		button.addEventListener('click', function () {
			openModal(button.getAttribute('data-platform-open'), button);
		});
	});

	document.querySelectorAll('.k-platform-modal').forEach(function (dialog) {
		dialog.addEventListener('click', function (event) {
			if (event.target === dialog) {
				dialog.close();
			}
		});

		dialog.addEventListener('close', function () {
			if (lastFocus) {
				lastFocus.focus();
				lastFocus = null;
			}
		});

		const closeButton = dialog.querySelector('[data-platform-close]');

		if (closeButton) {
			closeButton.addEventListener('click', function () {
				dialog.close();
			});
		}
	});
})();
