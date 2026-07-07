<?php

/**
 * HTML Escape
 *
 * @param ?string $str
 * @return string
 */
function html_escape(?string $str): string
{
	return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}


/**
 * Keep input data
 *
 * @param string $key
 * @param array $data
 */
function old($key, $data)
{
	return html_escape(trim($data[$key] ?? ''));
}


/**
 * DB Connection
 *
 * @return PDO
 */
function get_pdo(): PDO
{
	$config = require_once(__DIR__ . '/../../config/database.php');

	$dsn = sprintf(
		'mysql:host=%s;port=%s;dbname=%s;charset=%s',
		$config['host'],
		$config['port'],
		$config['database'],
		$config['charset']
	);

	$pdo = new PDO(
		$dsn,
		$config['username'],
		$config['password'],
	);

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $pdo;
}