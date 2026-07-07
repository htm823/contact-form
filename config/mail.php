<?php

return [
	// SMTP Settings
	'host'     => $_ENV['MAIL_HOST'],
	'port'     => (int) $_ENV['MAIL_PORT'],
	'username' => $_ENV['MAIL_USERNAME'],
	'password' => $_ENV['MAIL_PASSWORD'],

	'charset'  => 'UTF-8',
	'encoding' => 'base64',

	// Email addresses
	'from' => $_ENV['MAIL_FROM'],
	'to' => $_ENV['MAIL_TO'],

	// Administrator notification email
	'admin' => [
		'subject' => '新しいお問い合わせがあります',

		'body_header' => <<<TEXT
お問い合わせフォームから送信がありました。

お問い合わせ内容
--------------------------

TEXT,


		'body_footer' => '',
	],

	// Automatic reply email
	'reply' => [
		'subject' => 'お問い合わせありがとうございます',

		'body_header' => <<<TEXT
この度はお問い合わせいただきありがとうございます。

以下の内容でお問い合わせを受け付けました。

お問い合わせ内容
--------------------------

TEXT,

		'body_footer' => <<<TEXT

本メールは送信専用メールアドレスから自動送信されています。
このメールにご返信いただいてもご対応できません。

TEXT,
	],
];