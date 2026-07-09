<?php

require_once(__DIR__ . '/../lib/functions/utils.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$form_data = $_POST;
} else {
	$form_data = $_SESSION['POST'] ?? [];
}

$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['POST'], $_SESSION['errors']);

// Subjects
$contents = [
	'full-time' => 'フルタイム',
	'part-time' => 'パートタイム',
	'internship' => 'インターンシップ',
];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<title>お問い合わせフォーム</title>
	<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
</head>

<body class="bg-light">
	<div class="container-lg pt-5 pb-5">
		<h1 class="fs-3 mb-5">お問い合わせフォーム</h1>
		<form action="../confirm/index.php" method="post" class="h-adr">
			<input type="hidden" class="p-country-name" value="Japan">
			<p class="pb-4 mb-0">
				<span class="text-danger">*</span>の項目は入力必須です。
			</p>

			<!-- Error messages -->
			<?php if (isset($errors) && $errors) { ?>
				<div class="error-messages pb-4">
					<?php foreach ($errors as $error) { ?>
						<p class="text-danger mb-2"><i class="bi bi-exclamation-circle"></i><?= html_escape($error); ?></p>
					<?php } ?>
				</div>
			<?php } ?>

			<table class="table table-borderless">
				<tbody>
					<tr>
						<th scope="row"><span class="text-danger">*</span>お名前</th>
						<td>
							<input
								type="text"
								class="form-control"
								name="name"
								autocomplete="off"
								placeholder="山田花子"
								value="<?= old('name', $form_data); ?>">
						</td>
					</tr>
					<tr>
						<th scope="row"><span class="text-danger">*</span>フリガナ</th>
						<td>
							<input
								type="text"
								class="form-control"
								name="kana"
								autocomplete="off"
								placeholder="ヤマダハナコ"
								value="<?= old('kana', $form_data); ?>">
						</td>
					</tr>
					<tr>
						<th scope="row"><span class="text-danger">*</span>メール</th>
						<td>
							<input
								type="email"
								class="form-control"
								name="email"
								autocomplete="off"
								placeholder="example@gmail.com"
								value="<?= old('email', $form_data);; ?>">
						</td>
					</tr>
					<tr>
						<th scope="row"><span class="text-danger">*</span>電話番号</th>
						<td>
							<input
								type="tel"
								class="form-control"
								name="tel"
								autocomplete="off"
								placeholder="080-8787-8787"
								value="<?= old('tel', $form_data); ?>">
						</td>
					</tr>
					<tr>
						<th scope="row"><span class="text-danger">*</span>郵便番号</th>
						<td>
							<div class="input-group">
								<span class="input-group-text">〒</span>
								<input
									type="text"
									class="p-postal-code form-control"
									name="postal_code"
									size="8"
									maxlength="8"
									autocomplete="off"
									placeholder="130-0000"
									value="<?= old('postal_code', $form_data); ?>">
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><span class="text-danger">*</span>ご住所</th>
						<td>
							<input
								type="text"
								class="form-control p-region p-locality p-street-address p-extended-address"
								name="address"
								autocomplete="off"
								placeholder="宮城県〇〇市〇〇町1-1　サニーマンション　108号室"
								value="<?= old('address', $form_data); ?>">
						</td>
					</tr>
					<tr>
						<th scope="row">性別</th>
						<td>
							<div class="input-group-text bg-white shadow-sm bg-body-tertiary rounded">
								<div class="form-check form-check-inline">
									<input
										id="male"
										class="form-check-input"
										type="radio"
										name="gender"
										value="man"
										<?= ($form_data['gender'] ?? '') === 'man' ? 'checked' : ''; ?>>
									<label class="form-check-label" for="male">
										男性
									</label>
								</div>
								<div class="form-check form-check-inline">
									<input
										id="female"
										class="form-check-input"
										type="radio"
										name="gender"
										value="woman"
										<?= ($form_data['gender'] ?? '') === 'woman' ? 'checked' : ''; ?>>
									<label class="form-check-label" for="female">
										女性
									</label>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><span class="text-danger">*</span>応募内容</th>
						<td>
							<select class="form-control" name="content">
								<option value="">-- 以下からご選択ください --</option>
								<?php foreach ($contents as $key => $content) { ?>
									<option
										value="<?= $key; ?>"
										<?= (isset($form_data['content']) && $form_data['content']) && $form_data['content'] === $key ? 'selected' : ''; ?>>
										<?= $content; ?>
									</option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">ご質問等</th>
						<td>
							<textarea class="form-control" name="message" placeholder="例：書類のフォーマットが知りたい"><?= old('message', $form_data); ?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="d-grid col-6 pt-4 mx-auto">
				<input
					type="submit"
					name="confirm"
					value="内容確認ページへ"
					class="btn btn-secondary btn-lg">
			</div>
		</form>
	</div>
	<script
		src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
		crossorigin="anonymous">
	</script>
</body>

</html>