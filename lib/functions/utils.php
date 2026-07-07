<?php

/**
 * エスケープ
 *
 * @param ?string $str
 * @return string
 */
function html_escape(?string $str): string
{
	return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
