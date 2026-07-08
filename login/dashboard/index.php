<?php

require_once(__DIR__ . '/../../lib/functions/utils.php');
require_once(__DIR__ . '/../../config/init.php');

session_start();

$session = $_SESSION ?? [];

// Check Login Status
$is_logged_in = isset($session['id']);

if (!$is_logged_in) {
	header("Location: ../input/index.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script>
		$(function() {
			$("#logout").click(function() {
				var result = confirm('本当にログアウトしますか？');
				if (result) {
					$.ajax({
						url: '../logout/index.php',
						success: function() {
							window.location.href = '../input/index.php';
						}
					});
				}
			});
		});
	</script>
	<title>ダッシュボード</title>
</head>

<body class="bg-light d-flex bd-highlight">
	<div class="align-self-start p-5 flex-shrink-0 bd-highlight border-end">
		<div class="p-2">
			<a href="index.php" class="fw-bold" style="text-decoration: none; color: inherit;">ダッシュボード</a>
		</div>
		<div class="p-2">
			<a href="../email_index/index.php" style="text-decoration: none; color: inherit">メール受信</a>
		</div>
		<div class="p-2">
			<p id="logout" style="text-decoration: none; color: inherit; cursor: pointer;">ログアウト</p>
		</div>
	</div>
	</div>
	<div class="p-5 w-100 bd-highlight">
		<h3>最新メール情報</h3>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>