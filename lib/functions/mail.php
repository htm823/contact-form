<?php

/**
 * Check read status
 *
 * @param PDO $pdo
 * @param integer $id
 * @return bool
 */
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


/**
 * Mark mail as read
 *
 * @param PDO $pdo
 * @param integer $id
 * @return void
 */
function markAsRead(PDO $pdo, int $id): void
{
	$sql = "UPDATE mails SET status = 1 WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		':id' => $id,
	]);
}


/**
 * Get mails from database
 *
 * @param PDO $pdo
 * @param integer $id
 * @return ?array
 */
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