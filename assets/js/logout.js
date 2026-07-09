'use strict';

/**
 * Logout
 *
 * @return {void}
 */
$(function logout() {
	$('#logout').click(function (e) {
		e.preventDefault();

		const isConfirm = window.confirm('本当にログアウトしますか？');

		if (!isConfirm) {
			return;
		}

		$.ajax({
			url: '../logout/index.php',
			success: function () {
				window.location.href = '../input/index.php';
			},
		});
	});
});
