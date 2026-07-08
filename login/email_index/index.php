<?php

require_once(__DIR__ . '/../../lib/functions/utils.php');
require_once(__DIR__ . '/../../config/init.php');

session_start();

$get = $_GET;

?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="../../css/style.css">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script>
		$(function() {
			$("#logout").click(function() {
				var result = window.confirm('本当にログアウトしますか？');
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
	<title>メール受信一覧</title>
</head>

<body class="bg-light d-flex bd-highlight">
	<div class="align-self-start p-5 flex-shrink-0 bd-highlight border-end">
		<div class="p-2">
			<a href="../dashboard/index.php" style="text-decoration: none; color: inherit;">ダッシュボード</a>
		</div>
		<div class="p-2">
			<a href="index.php" class="fw-bold" style="text-decoration: none; color: inherit">メール受信</a>
		</div>
		<div class="p-2">
			<p id="logout" style="text-decoration: none; color: inherit; cursor: pointer;">ログアウト</p>
		</div>
	</div>
	<div class="p-5 w-100 bd-highlight">
		<div class="heading">
			<h3>メール受信一覧</h3>
			<div class="search">
				<form method="GET">
					<div class="row g-1 align-items-center">
						<div class="col-auto">
							<input type="text" name="search" class="form-control" value="<?= old('search', $get); ?>" placeholder="キーワードで絞り込み">
						</div>
						<div class="col-auto">
							<input type="submit" class="btn btn-secondary" value="検索">
						</div>
					</div>
				</form>
			</div>
		</div>

		<?php
		try {
			$pdo = get_pdo();

			// Search condition
			$search_term = $get['search'] ?? '';

			$search_condition = '';
			$params = [];

			if ($search_term !== '') {
				$search_condition = "WHERE (name LIKE :search OR email LIKE :search OR tel LIKE :search)";
				$params[':search'] = "%{$search_term}%";
			}

			// Paging
			$count_sql = "SELECT COUNT(*) FROM mails {$search_condition}";
			$count_stmt = $pdo->prepare($count_sql);
			$count_stmt->execute($params);
			$total = $count_stmt->fetchColumn();

			$page = max(1, (int) ($get['page'] ?? 1));
			$page_size = 5;
			$total_pages = ceil($total / $page_size);
			$start = ($page - 1) * $page_size;

			// Sorting
			$sort_order = strtoupper($get['order'] ?? 'DESC');

			if (!in_array($sort_order, ['ASC', 'DESC'], true)) {
				$sort_order = 'DESC';
			}

			$is_desc = ($sort_order === 'DESC');
			$reverse_sort_order = $is_desc ? 'ASC' : 'DESC';
		?>

			<div class="text-end mb-3 mt-5">
				<?php for ($i = 1; $i <= $total_pages; $i++) { ?>
					<a
						href="?page=<?= $i; ?>&order=<?= $sort_order; ?>&search=<?= urlencode($search_term); ?>"
						class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover d-inline-block m-2 <?= $page === $i ? 'fw-bold' : ''; ?>">
						<?= $i; ?>
					</a>
				<?php } ?>
				<a
					href="?page=<?= $page; ?>&order=<?= $reverse_sort_order; ?>&search=<?= urlencode($search_term); ?>"
					class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover d-inline-block m-2">
					<span><?= $is_desc ? '<i class="bi bi-sort-up-alt"></i>' : '<i class="bi bi-sort-down"></i>'; ?></span>
				</a>
			</div>
			<table class="table table-bordered text-center">
				<thead>
					<tr>
						<th scope="col">既読・未読</th>
						<th scope="col">送信日時</th>
						<th scope="col">名前</th>
						<th scope="col">メールアドレス</th>
						<th scope="col">電話番号</th>
						<th scope="col">詳細</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sort_sql = "SELECT * FROM mails {$search_condition} ORDER BY created_at {$sort_order} LIMIT {$start}, {$page_size}";
					$sort_stmt = $pdo->prepare($sort_sql);
					$sort_stmt->execute($params);

					foreach ($sort_stmt as $record) {
						$is_unread = ((int)$record['status'] === 0);
						$statusClass = $is_unread ? 'text-danger' : '';
						$statusBtnText = $is_unread ? '未読' : '既読';
					?>
						<tr>
							<td>
								<div class='d-grid gap-2 d-md-block'>
									<p class="<?= $statusClass; ?>"><?= $statusBtnText; ?></p>
								</div>
							</td>
							<td><?= html_escape($record['created_at']); ?></td>
							<td><?= html_escape($record['name']); ?></td>
							<td><?= html_escape($record['email']); ?></td>
							<td><?= html_escape($record['tel']); ?></td>
							<td>
								<div class='d-grid gap-2 d-md-block'>
									<a href="../email_show/index.php?id=<?= $record['id']; ?>" class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'>詳細ページ</a>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php
		} catch (PDOException $e) {
			// Development
			$msg = $e->getMessage();
			echo "Error: " . $msg;

			// Production
			// error_log($msg);
			// echo 'Failed to save.';
		}
		?>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>