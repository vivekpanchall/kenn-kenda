/**
 * Signup management UI helpers.
 */
(function () {
    'use strict';

    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        if (!form.classList.contains('js-confirm-delete')) {
            return;
        }

        var message = form.getAttribute('data-confirm')
            || 'Are you sure you want to delete this signup?';

        if (!window.confirm(message)) {
            event.preventDefault();
        }
    });
})();
