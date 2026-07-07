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
		'subject' => 'New enquiry received via the contact form',

		'body_header' => <<<TEXT
			A new enquiry has been submitted via the contact form.

			Enquiry details
			--------------------------

		TEXT,

		'body_footer' => '',
	],

	// Automatic reply email
	'reply' => [
		'subject' => 'Thank you for your enquiry',

		'body_header' => <<<TEXT
			Thank you for getting in touch.
			Your enquiry has been received with the following details.

			Enquiry details
			--------------------------
		TEXT,

		'body_footer' => <<<TEXT
			This is an automated message set form an unmonitored email address.
			Please do not reply to this email.
		TEXT
	],
];