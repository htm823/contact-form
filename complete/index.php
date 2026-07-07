<?php

require_once(__DIR__ . '/../lib/functions/utils.php');
require_once(__DIR__ . '/../config/init.php');

$mailConfig = require_once(__DIR__ . '/../config/mail.php');

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$posts = [
		0 => [
			'label' => '名前',
			'value' => html_escape($_POST['name']),
		],
		1 => [
			'label' => 'フリガナ',
			'value' => html_escape($_POST['kana']),
		],
		2 => [
			'label' => 'メールアドレス',
			'value' => html_escape($_POST['email']),
		],
		3 => [
			'label' => '電話番号',
			'value' => html_escape($_POST['tel']),
		],
		4 => [
			'label' => '住所',
			'value' => html_escape('〒' . $_POST['postal_code_1'] . '-' . $_POST['postal_code_2'] . ' ' . $_POST['address']),
		],
		5 => [
			'label' => '性別',
			'value' => html_escape($_POST['gender']),
		],
		6 => [
			'label' => '応募内容',
			'value' => html_escape($_POST['content']),
		],

		7 => [
			'label' => '質問内容',
			'value' => html_escape($_POST['message']),
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
			$_POST['name'] .
			$mailConfig['admin']['body_header'] .
			$body .
			$mailConfig['admin']['body_footer'];

		// Auto reply settings
		$mail->clearAddresses();
		$mail->setFrom($mailConfig['from']);
		$mail->addAddress($_POST['email']);
		$mail->Subject = $mailConfig['reply']['subject'];
		$mail->Body    =
			$_POST['name'] .
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
	}
}

try {
	// PDO設定
	$dsn = 'mysql:dbname=form_study;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';

	$dbh = new PDO($dsn, $user, $password);

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$name = $_POST['name'];
	$kana = $_POST['kana'];
	$email = $_POST['email'];
	$tel = $_POST['tel'];
	$postal_code = $_POST['postal_code_1'] . $_POST['postal_code_2'];
	$address = $_POST['address'];
	$gender = $_POST['gender'];
	$content = $_POST['content'];
	$question = $_POST['message'];
	$created_at = date("Y-m-d H:i:s");
	$updated_at = date("Y-m-d H:i:s");

	$sql = "INSERT INTO mails (name, kana, email, tel, postal_code, address, gender, content, question, created_at, updated_at) VALUES (:name, :kana, :email, :tel, :postal_code, :address, :gender, :content, :question, :created_at, :updated_at)";
	$stmt = $dbh->prepare($sql);

	$stmt->bindParam(':name', $name);
	$stmt->bindParam(':kana', $kana);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':tel', $tel);
	$stmt->bindParam(':postal_code', $postal_code);
	$stmt->bindParam(':address', $address);
	$stmt->bindParam(':gender', $gender);
	$stmt->bindParam(':content', $content);
	$stmt->bindParam(':question', $question);
	$stmt->bindParam(':created_at', $created_at);
	$stmt->bindParam(':updated_at', $updated_at);

	$stmt->execute();

	echo "データが追加されました。";
} catch (PDOException $e) {
	$msg = $e->getMessage();
	echo "エラー：" . $msg;
}

$dbh = null;

// セッション情報削除
session_destroy();

// 完了画面に遷移
header("Location: thanks.html");
