<?php

require_once(__DIR__ . '/../../lib/functions/utils.php');
require_once(__DIR__ . '/../../config/init.php');

session_start();

$get = $_GET;

// Subjects
$contents = [
	'full-time' => 'フルタイム',
	'part-time' => 'パートタイム',
	'internship' => 'インターンシップ',
];

$pdo = get_pdo();

function isUnread(PDO $pdo, int $id): bool
{
	$sql = "SELECT status FROM mails WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		':id' => $id,
	]);

	$mails = $stmt->fetch(PDO::FETCH_ASSOC);

	return $mails && $mails['status'] === 0;
}

function markAsRead(PDO $pdo, int $id): void
{
	$sql = "UPDATE mails SET status = 1 WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		':id' => $id,
	]);
}

function getMail(PDO $pdo, int $id): ?array
{
	$sql = "SELECT * FROM mails WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		':id' => $id,
	]);

	$mails = $stmt->fetch(PDO::FETCH_ASSOC);

	return $mails ?: null;
}

$mails = null;

try {
	if (isset($get['id'])) {
		$id = $get['id'];

		if (isUnread($pdo, $id)) {
			markAsRead($pdo, $id);
		}

		$mails = getMail($pdo, $id);
	}
} catch (PDOException $e) {
	// Development
	$msg = $e->getMessage();
	echo "Error: " . $msg;

	// Production
	// error_log($msg);
	// echo 'Failed to save.';
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
	<title>メール受信詳細</title>
</head>

<body class="bg-light d-flex bd-highlight">
	<div class="align-self-start p-5 flex-shrink-0 bd-highlight border-end vh-100">
		<div class="p-2">
			<a href="../email_index/index.php" class="fw-bold" style="text-decoration: none; color: inherit">メール受信</a>
		</div>
		<div class="p-2">
			<p id="logout" style="text-decoration: none; color: inherit; cursor: pointer;">ログアウト</p>
		</div>
	</div>
	<div class="p-5 w-100 bd-highlight">
		<div class="container-lg">
			<h3>メール受信詳細</h3>
			<table class="table mt-4 mb-5">
				<tbody>
					<?php if ($mails) { ?>
						<tr>
							<th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">名前</th>
							<td><?= html_escape($mails['name']); ?></td>
						<tr>
							<th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">メールアドレス</th>
							<td><?= html_escape($mails['email']); ?></td>
						</tr>
						<tr>
							<th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">電話番号</th>
							<td><?= html_escape($mails['tel']); ?></td>
						</tr>
						<tr>
							<th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">郵便番号</th>
							<td><?= html_escape($mails['postal_code']); ?></td>
						</tr>
						<tr>
							<th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">住所</th>
							<td><?= html_escape($mails['address']); ?></td>
						</tr>
						<tr>
							<th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">性別</th>
							<td><?= html_escape($mails['gender']); ?></td>
						</tr>
						<tr>
							<th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">応募内容</th>
							<td><?= html_escape($contents[$mails['content']]); ?></td>
						</tr>
						<tr>
							<th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">質問</th>
							<td><?= nl2br(html_escape($mails['question'])); ?></td>
						</tr>
						<tr>
							<th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">送信日時</th>
							<td><?= html_escape($mails['created_at']); ?></td>
						</tr>
					<?php } else { ?>
						<tr>
							<td colspan="2">データが存在しません</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<button class="btn btn-secondary btn-lg" type="button" onclick="history.back()">戻る</button>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>