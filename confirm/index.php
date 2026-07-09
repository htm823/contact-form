<?php

require_once(__DIR__ . '/../lib/functions/utils.php');

session_start();

$form_data = $_POST ?? [];

if (!isset($form_data) && !$form_data) {
	header('Location: ../input/index.php');
	exit;
}

$contents = [
	'full-time' => 'フルタイム',
	'part-time' => 'パートタイム',
	'internship' => 'インターンシップ',
];

$genders = [
	'man' => '男性',
	'woman' => '女性',
];

$errors = [];

if (empty($form_data['name'])) {
	$errors[] = '【お名前】は必須項目です';
}

if (empty($form_data['kana'])) {
	$errors[] = '【フリガナ】は必須項目です';
} else if (!preg_match('/\A[ァ-ヿ]+\z/u', $form_data['kana'])) {
	$errors[] = '【フリガナ】はカタカナで入力してください';
}

if (empty($form_data['email'])) {
	$errors[] = '【メール】は必須項目です';
} else if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
	$errors[] = '【メール】の形式が正しくありません';
}

if (empty($form_data['tel'])) {
	$errors[] = '【電話番号】は必須項目です';
} else if (!preg_match('/\A0\d{1,4}-\d{1,4}-\d{3,4}\z/', $form_data['tel'])) {
	$errors[] = '【電話番号】はハイフン含め13桁で入力してください';
}

if (empty($form_data['postal_code'])) {
	$errors[] = '【郵便番号】は必須項目です';
} else if (!preg_match('/\A\d{3}-\d{4}\z/', $form_data['postal_code'])) {
	$errors[] = '【郵便番号】はハイフン含め8桁で入力してください';
}

if (empty($form_data['address'])) {
	$errors[] = '【ご住所】は必須項目です';
}

if (empty($form_data['content'])) {
	$errors[] = '【応募内容】は必須項目です';
}

if ($errors) {
	$_SESSION["errors"] = $errors;
	$_SESSION["POST"] = $form_data;
	header("Location: ../input/index.php");
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<title>確認ページ</title>
</head>

<body class="bg-light">
	<div class="container-lg pt-5 pb-5">
		<p class="mb-0">以下の内容でよろしければ【送信】ボタンをクリックしてください。</p>
		<form action=" ../complete/index.php" method="post">
			<table class="table mb-5 mt-5">
				<tbody>
					<tr>
						<th scope="row" class="table-secondary">お名前</th>
						<td><?= html_escape($form_data['name']); ?></td>
						<input type="hidden" name="name" value="<?= html_escape($form_data['name']); ?>">
					</tr>
					<tr>
						<th scope="row" class="table-secondary">フリガナ</th>
						<td><?= html_escape($form_data['kana']); ?></td>
						<input type="hidden" name="kana" value="<?= html_escape($form_data['kana']); ?>">
					</tr>
					<tr>
						<th scope="row" class="table-secondary">メールアドレス</th>
						<td><?= html_escape($form_data['email']); ?></td>
						<input type="hidden" name="email" value="<?= html_escape($form_data['email']); ?>">
					</tr>
					<tr>
						<th scope="row" class="table-secondary">電話番号</th>
						<td><?= html_escape($form_data['tel']); ?></td>
						<input type="hidden" name="tel" value="<?= html_escape($form_data['tel']); ?>">
					</tr>
					<tr>
						<th scope="row" class="table-secondary">ご住所</th>
						<td>
							<span>〒</span>
							<?= html_escape($form_data['postal_code']); ?>
							<br />
							<?= html_escape($form_data['address']); ?>
						</td>
						<input type="hidden" name="postal_code" value="<?= html_escape($form_data['postal_code']); ?>">
						<input type="hidden" name="address" value="<?= html_escape($form_data['address']); ?>">
					</tr>
					<tr>
						<th scope="row" class="table-secondary">性別</th>
						<td>
							<?= html_escape($genders[$form_data['gender'] ?? ''] ?? ''); ?>
						</td>
						<input type="hidden" name="gender" value="<?= html_escape($form_data['gender'] ?? '') ?>">
					</tr>
					<tr>
						<th scope="row" class="table-secondary">応募内容</th>
						<td><?= html_escape($contents[$form_data['content']]) ?></td>
						<input type="hidden" name="content" value="<?php echo $form_data['content']; ?>">
					</tr>
					<tr>
						<th scope="row" class="table-secondary">ご質問等</th>
						<td><?= nl2br(html_escape($form_data['message'] ?? '')); ?></td>
						<input type="hidden" name="message" value="<?php echo $form_data['message'] ?? ''; ?>">
					</tr>
				</tbody>
			</table>
			<div class="d-flex mx-auto gap-3 w-50">
				<!-- Back to Input Page -->
				<div class="d-grid gap-2 col-6 mx-auto">
					<button
						type="submit"
						formaction="../input/index.php"
						formmethod="post"
						class="btn btn-outline-secondary btn-lg">
						戻る
					</button>
				</div>
				<div class="d-grid gap-2 col-6 mx-auto">
					<input type="submit" name="complete" value="送信" class="btn btn-secondary btn-lg">
				</div>
			</div>
		</form>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>