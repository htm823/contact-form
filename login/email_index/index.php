<?php

require_once(__DIR__ . '/../../lib/functions/utils.php');
require_once(__DIR__ . '/../../config/init.php');

session_start();

$get = $_GET;

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
	<meta property="og:title" content="Contact Form">
	<meta property="og:description" content="A contact management system built with PHP and MySQL.">
	<meta property="og:type" content="website">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="description" content="A contact management system built with PHP and MySQL.">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="icon" href="../../assets/img/favicon.ico">
	<title>お問い合わせ一覧｜管理画面</title>
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
				<div class="d-flex justify-content-between">
					<h1 class="fs-3">お問い合わせ一覧</h1>
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
						<form class="search" method="GET">
							<div class="row g-1 align-items-center">
								<div class="col-auto">
									<input
										type="text"
										name="search"
										class="form-control"
										value="<?= old('search', $get); ?>"
										placeholder="キーワードで絞り込み">
								</div>
								<div class="col-auto">
									<input type="submit" class="btn btn-secondary" value="検索">
								</div>
							</div>
						</form>
				</div>
				<?php if ($total > 0) { ?>
					<div class="text-end mb-3 mt-5">
						<?php for ($i = 1; $i <= $total_pages; $i++) { ?>
							<a
								href="?page=<?= $i; ?>&order=<?= $sort_order; ?>&search=<?= urlencode($search_term); ?>"
								class="link-secondary d-inline-block m-2 <?= $page === $i ? 'fw-bold' : ''; ?>">
								<?= $i; ?>
							</a>
						<?php } ?>
						<a
							href="?page=<?= $page; ?>&order=<?= $reverse_sort_order; ?>&search=<?= urlencode($search_term); ?>"
							class="link-secondary d-inline-block m-2">
							<span><?= $is_desc ? '<i class="bi bi-sort-up-alt"></i>' : '<i class="bi bi-sort-down"></i>'; ?></span>
						</a>
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col" class="table-secondary">既読・未読</th>
								<th scope="col" class="table-secondary">送信日時</th>
								<th scope="col" class="table-secondary">名前</th>
								<th scope="col" class="table-secondary">メールアドレス</th>
								<th scope="col" class="table-secondary">電話番号</th>
								<th scope="col" class="table-secondary">詳細</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sort_sql = "SELECT * FROM mails {$search_condition} ORDER BY created_at {$sort_order} LIMIT {$start}, {$page_size}";
							$sort_stmt = $pdo->prepare($sort_sql);
							$sort_stmt->execute($params);

							$records = $sort_stmt->fetchALL(PDO::FETCH_ASSOC);

							foreach ($records as $record) {
								$is_unread = ($record['status'] === 0);
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
											<a href="../email_show/index.php?id=<?= $record['id']; ?>&page=<?= $page; ?>&order=<?= $sort_order; ?>&search=<?= urlencode($search_term); ?>" class='link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'>詳細ページ</a>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } else { ?>
					<p class="mt-5">データがありません</p>
				<?php } ?>
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
		</main>
	</div>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="../../assets/js/logout.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>