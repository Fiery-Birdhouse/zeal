<?php
if (!defined(INCL_FILE)) die('HTTP/1.0 403 Forbidden');

$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'; // Verifica se é um request Ajax
$host = isset($_SERVER['HTTP_REFERER']) ? strpos($_SERVER['HTTP_REFERER'], getenv('HTTP_HOST')) : ""; // Verifica se o request vem do server
if(!$ajax || $host === false) {
	exit('Forbidden');
}
?>
