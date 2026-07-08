<?php

require_once(__DIR__ . '/../../lib/functions/utils.php');

session_start();

$form_data = $_SESSION['POST'] ?? [];
$errors = $_SESSION['errors'] ?? [];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<title>ログインページ</title>
</head>

<body class="text-bg-light">
	<div class="container-lg pt-5 pb-5">
		<form action="../auth/index.php" method="POST">
			<!-- Error messages -->
			<?php if ($errors) { ?>
				<div class="error-messages pb-4">
					<?php foreach ($errors as $error) { ?>
						<p class="text-danger mb-2"><i class="bi bi-exclamation-circle"></i><?= $error; ?></p>
					<?php } ?>
				</div>
			<?php } ?>
			<table class="table table-borderless">
				<tbody>
					<tr class="table-light">
						<th scope="row">ID</th>
						<td>
							<input
								class="form-control"
								name="email"
								type="email"
								autocomplete="off"
								placeholder="メールアドレスを入力"
								value="<?= old('email', $form_data); ?>">
						</td>
					</tr>
					<tr class="table-light">
						<th scope="row">パスワード</th>
						<td>
							<input
								class="form-control"
								name="password"
								type="password"
								autocomplete="off"
								placeholder="パスワードを入力（英数字8桁）"
								value="<?= old('password', $form_data); ?>">
						</td>
					</tr>
				</tbody>
			</table>
			<div class="d-grid gap-2 col-6 mx-auto pt-4">
				<input type="submit" name="login" value='ログイン' class="btn btn-secondary btn-lg">
			</div>
		</form>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>