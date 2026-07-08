<?php

require_once(__DIR__ . '/../../lib/functions/utils.php');
require_once(__DIR__ . '/../../config/init.php');

session_start();

$session = $_SESSION ?? [];

// Check POST data existence
$form_data = $_POST ?? [];
if (!$form_data) {
	header("Location: ../input/index.php");
	exit;
}

/* ========================
Validations
========================= */

$errors = [];

$email = $form_data['email'] ?? '';
$password = $form_data['password'] ?? '';

if (!$email) {
	$errors[] = 'メールアドレスを入力してください';
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$errors[] = 'メールアドレスの形式が正しくありません';
}

if (!$password) {
	$errors[] = 'パスワードを入力してください';
} else if (!preg_match('/\A[a-z\d]{8}\z/i', $password)) {
	$errors[] = 'パスワードは英数字8桁で入力してください';
}

if ($errors) {
	$session['errors'] = $errors;
	$session['POST'] = $_POST;
	$_SESSION = $session;

	header("Location: ../input/index.php");
	exit;
}

/* ========================
Insert form data into DB
========================= */

try {
	$pdo = get_pdo();

	$sql = "SELECT * FROM users WHERE email = :email";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		':email' => $email,
	]);

	$member = $stmt->fetch();

	// For security, do not distinguish between an invalid email and an invalid password.
	// Password hashing will be implemented later.
	if (!$member || $password !== $member['password']) {
		$errors[] = 'メールアドレスまたはパスワードが正しくありません';
	} else {
		$session['id'] = $member['id'];
		$session['email'] = $member['email'];
	}

	$is_logged_in = true;
} catch (PDOException $e) {
	// Development
	$msg = $e->getMessage();
	echo "Error: " . $msg;

	// Production
	// error_log($msg);
	// echo 'Failed to save.';

	exit;
}

if ($errors) {
	$session['errors'] = $errors;
	$_SESSION = $session;

	header("Location: ../input/index.php");
	exit;
}

$_SESSION = $session;

header("Location: ../dashboard/index.php");
exit;
