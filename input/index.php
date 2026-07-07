<?php

require_once(__DIR__ . '/../lib/functions/utils.php');
require_once(__DIR__ . '/../config/init.php');

session_start();

$form_data = $_SESSION['POST'] ?? [];
$errors    = $_SESSION['errors'] ?? [];

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
	<form action="../confirm/index.php" method="post" class="h-adr">
		<span class="p-country-name" style="display:none;">Japan</span>
		<p>
			<span class="text-danger">*</span>の項目は入力必須項目です。必ず入力または選択してください。
		</p>

		<!-- Error messages -->
		<?php if (isset($errors) && $errors) { ?>
			<?php foreach ($errors as $error) { ?>
				<div class="bg-danger text-white w-50 shadow-sm">
					<i class="bi bi-exclamation-circle-fill"></i>
					<?= html_escape($error); ?>
				</div>
			<?php } ?>
		<?php } ?>

		<table class="table table-borderless bg-white shadow-sm p-3 bg-body-tertiary rounded">
			<tbody>
				<tr>
					<th scope="row"><span class="text-danger">*</span>お名前</th>
					<td>
						<input
							type="text"
							class="form-control"
							name="name"
							autocomplete="off"
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
							value="<?= old('kana', $form_data); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><span class="text-danger">*</span>メールアドレス</th>
					<td>
						<input
							type="email"
							class="form-control"
							name="email"
							autocomplete="off"
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
							value="<?= old('tel', $form_data); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row"><span class="text-danger">*</span>ご住所</th>
					<td>
						<div class="input-group mb-3">
							<span class="input-group-text">〒</span>
							<input
								type="text"
								class="form-control"
								name="postal_code_1"
								autocomplete="off"
								value="<?= old('postal_code_1', $form_data); ?>">
							<span class="input-group-text bg-white">-</span>
							<input
								type="text"
								class="form-control"
								name="postal_code_2"
								autocomplete="off"
								value="<?= old('postal_code_2', $form_data); ?>">
						</div>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<input
							type="text"
							class="form-control p-region p-locality p-street-address p-extended-address"
							name="address"
							autocomplete="off"
							value="<?= old('address', $form_data); ?>">
					</td>
				</tr>
				<tr>
					<th scope="row">性別</th>
					<td>
						<div class="input-group-text bg-white shadow-sm p-3 bg-body-tertiary rounded">
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
						<textarea class="form-control" name="message"><?= old('message', $form_data); ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="d-grid gap-2 col-6 mx-auto">
			<input
				type="submit"
				name="confirm"
				value="内容確認ページへ"
				class="btn btn-secondary shadow-sm">
		</div>
	</form>
	<script
		src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
		crossorigin="anonymous">
	</script>
</body>

</html>