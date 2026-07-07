<?php

require_once(__DIR__ . '/../lib/functions/utils.php');
require_once(__DIR__ . '/../config/init.php');

$mailConfig = require_once(__DIR__ . '/../config/mail.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

// Check POST data existence
$form_data = $_POST ?? [];


/* ========================
Insert form data into DB
========================= */
try {
	$pdo = get_pdo();

	$sql = "
		INSERT INTO mails (
			name,
			kana,
			email,
			tel,
			postal_code,
			address,
			gender,
			content,
			question,
			created_at,
			updated_at
		)
		VALUES (
			:name,
			:kana,
			:email,
			:tel,
			:postal_code,
			:address,
			:gender,
			:content,
			:question,
			:created_at,
			:updated_at
		)
	";

	$stmt = $pdo->prepare($sql);

	$now = date('Y-m-d H:i:s');

	if (isset($form_data['gender']) && $form_data['gender']) {
		$gender = ($form_data['gender'] === 'man') ? '男性' : '女性';
	} else {
		$gender = '';
	}

	$stmt->execute([
		':name' => $form_data['name'],
		':kana' => $form_data['kana'],
		':email' => $form_data['email'],
		':tel' => $form_data['tel'],
		':postal_code' => $form_data['postal_code_1'] . $form_data['postal_code_2'],
		':address' => $form_data['address'],
		':gender' => $gender,
		':content' => $form_data['content'],
		':question' => $form_data['message'] ?? '',
		':created_at' => $now,
		':updated_at' => $now,
	]);
} catch (PDOException $e) {

	// Development
	$msg = $e->getMessage();
	echo "Error: " . $msg;

	// Production
	// error_log($msg);
	// echo 'Failed to save.';

	exit;
}


/* ============
Email Notification
============= */

$contents = [
	'full-time' => 'フルタイム',
	'part-time' => 'パートタイム',
	'internship' => 'インターンシップ',
];

$genders = [
	'man' => '男性',
	'woman' => '女性',
];

$posts = [
	0 => [
		'label' => '名前',
		'value' => html_escape($form_data['name']),
	],
	1 => [
		'label' => 'フリガナ',
		'value' => html_escape($form_data['kana']),
	],
	2 => [
		'label' => 'メールアドレス',
		'value' => html_escape($form_data['email']),
	],
	3 => [
		'label' => '電話番号',
		'value' => html_escape($form_data['tel']),
	],
	4 => [
		'label' => '住所',
		'value' => html_escape('〒' . $form_data['postal_code_1'] . '-' . $form_data['postal_code_2'] . ' ' . $form_data['address']),
	],
	5 => [
		'label' => '性別',
		'value' => $genders[$form_data['gender'] ?? ''] ?? '',
	],
	6 => [
		'label' => '応募内容',
		'value' => $contents[$form_data['content'] ?? ''] ?? '',
	],

	7 => [
		'label' => '質問内容',
		'value' => html_escape($form_data['message']),
	],
];

$body = "";
foreach ($posts as $post) {
	$body .= $post['label'] . "：\n" . $post['value'] . "\n\n";
}

$mail = new PHPMailer();

try {
	// Email settings
	$mail->CharSet  = $mailConfig['charset'];
	$mail->Encoding = $mailConfig['encoding'];

	$mail->isSMTP();
	$mail->Host     = $mailConfig['host'];
	$mail->SMTPAuth = true;
	$mail->Username = $mailConfig['username'];
	$mail->Password = $mailConfig['password'];
	$mail->Port     = $mailConfig['port'];

	// Admin email settings
	$mail->setFrom($mailConfig['from']);
	$mail->addAddress($mailConfig['to']);
	$mail->Subject = $mailConfig['admin']['subject'];
	$mail->Body    =
		$mailConfig['admin']['body_header'] .
		$body .
		$mailConfig['admin']['body_footer'];

	// Auto reply settings
	$mail->clearAddresses();
	$mail->setFrom($mailConfig['from']);
	$mail->addAddress($form_data['email']);
	$mail->Subject = $mailConfig['reply']['subject'];
	$mail->Body    =
		$form_data['name'] . " 様\n\n" .
		$mailConfig['reply']['body_header'] .
		$body .
		$mailConfig['reply']['body_footer'];

	$mail->send();
} catch (Exception $e) {
	// Development
	$msg = $e->getMessage();
	echo "Error: " . $msg;

	// Production
	// error_log($msg);
	// echo 'Failed to send.';

	exit;
}

// Destroy session
session_destroy();

// Move to Thanks Page
header("Location: thanks.html");
