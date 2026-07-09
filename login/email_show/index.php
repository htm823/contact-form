<?php

require_once(__DIR__ . '/../../lib/functions/utils.php');
require_once(__DIR__ . '/../../lib/functions/mail.php');
require_once(__DIR__ . '/../../config/init.php');

session_start();

$session = $_SESSION ?? [];

if (!isset($session['id'])) {
	header('Location: ../input/index.php');
	exit;
}

$get = $_GET;

// Subjects
$contents = [
	'full-time' => 'フルタイム',
	'part-time' => 'パートタイム',
	'internship' => 'インターンシップ',
];

$pdo = get_pdo();

$mails = null;

try {
	$id = (int)($get['id'] ?? 0);

	if ($id > 0) {
		$mails = getMail($pdo, $id);

		if ($mails && isUnread($pdo, $id)) {
			markAsRead($pdo, $id);
		}
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
	<meta property="og:title" content="Contact Form">
	<meta property="og:description" content="A contact management system built with PHP and MySQL.">
	<meta property="og:type" content="website">
	<meta property="og:image" content="https://contact-form.up.railway.app/assets/img/ogp.png">
	<meta property="og:url" content="https://contact-form.up.railway.app">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:image" content="https://contact-form.up.railway.app/assets/img/ogp.png">
	<meta name="description" content="A contact management system built with PHP and MySQL.">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link rel="icon" href="../../assets/img/favicon.ico">
	<title>お問い合わせ詳細｜管理画面</title>
</head>

<!-- Responsive will be implemented later -->

<body class="bg-light">
	<div class="container-lg d-flex">
		<aside class="p-5 flex-shrink-0 border-end vh-100">
			<nav class="control">
				<ul class="list-unstyled d-flex flex-column gap-3">
					<li>
						<a href="index.php" class="link-secondary text-decoration-none">お問い合わせ一覧</a>
					</li>
					<li>
						<a id="logout" href="javascript:void(0)" class="link-secondary text-decoration-none">ログアウト</a>
					</li>
				</ul>
			</nav>
		</aside>
		<main class="w-100">
			<div class="container p-5">
				<h1 class="fs-3">お問い合わせ詳細</h1>
				<?php if ($mails) { ?>
					<table class="table mt-5 mb-5">
						<tbody>
							<tr>
								<th scope="row" class="table-secondary">名前</th>
								<td><?= html_escape($mails['name']); ?></td>
							</tr>
							<tr>
								<th scope="row" class="table-secondary">メールアドレス</th>
								<td><?= html_escape($mails['email']); ?></td>
							</tr>
							<tr>
								<th scope="row" class="table-secondary">電話番号</th>
								<td><?= html_escape($mails['tel']); ?></td>
							</tr>
							<tr>
								<th scope="row" class="table-secondary">郵便番号</th>
								<td><?= html_escape($mails['postal_code']); ?></td>
							</tr>
							<tr>
								<th scope="row" class="table-secondary">住所</th>
								<td><?= html_escape($mails['address']); ?></td>
							</tr>
							<tr>
								<th scope="row" class="table-secondary">性別</th>
								<td><?= html_escape($mails['gender'] ?? ''); ?></td>
							</tr>
							<tr>
								<th scope="row" class="table-secondary">応募内容</th>
								<td><?= html_escape($contents[$mails['content']] ?? ''); ?></td>
							</tr>
							<tr>
								<th scope="row" class="table-secondary">質問</th>
								<td><?= nl2br(html_escape($mails['question'] ?? '')); ?></td>
							</tr>
							<tr>
								<th scope="row" class="table-secondary">送信日時</th>
								<td><?= html_escape($mails['created_at']); ?></td>
							</tr>
						</tbody>
					</table>
				<?php } else { ?>
					<p class="mt-5">データが存在しません</p>
				<?php } ?>
				<button class="btn btn-secondary btn-lg" type="button" onclick="history.back()">戻る</button>
			</div>
		</main>
	</div>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="../../assets/js/logout.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>