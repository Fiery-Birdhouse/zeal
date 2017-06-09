<?php
if (!defined(INCL_FILE)) die('HTTP/1.0 403 Forbidden');

// Impede que os cookies sejam utilizados pelo Javascript.
ini_set('session.cookie_httponly', 1);

// Carrega credenciais necessárias para o funcionamento do sistema
$credenciaisDir = __DIR__ . '/credenciais.json';

if (file_exists($credenciaisDir)) {
	$def_cred = file_get_contents($credenciaisDir);
	$def_cred = json_decode($def_cred);
} else {
	throw new Exception(notificacoes("z1"));
}
unset($credenciaisDir);

// Armazena conexão usada nas operações de Active Record
$connection = array();
$connection['host'] = $def_cred->database->host;
$connection['db'] = $def_cred->database->db;
$connection['user'] = $def_cred->database->user;
$connection['pass'] = $def_cred->database->pass;

setlocale(LC_ALL, 'pt_BR.utf8');
setlocale(LC_NUMERIC, 'en_US.utf8');
date_default_timezone_set($def_cred->timezone);
?>
