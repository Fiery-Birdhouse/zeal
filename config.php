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
	throw new Exception(notificacoes("c1"));
}
unset($credenciaisDir);

// Armazena conexões usaradas nas operação de Active Record
$connection = array();

$connection['production'] = array();
$connection['production']['host'] = $def_cred->dbProduction->host;
$connection['production']['db'] = $def_cred->dbProduction->db;
$connection['production']['user'] = $def_cred->dbProduction->user;
$connection['production']['pass'] = $def_cred->dbProduction->pass;

$connection['dev'] = array();
$connection['dev']['host'] = $def_cred->dbDev->host;
$connection['dev']['db'] = $def_cred->dbDev->db;
$connection['dev']['user'] = $def_cred->dbDev->user;
$connection['dev']['pass'] = $def_cred->dbDev->pass;

setlocale(LC_ALL, 'pt_BR.utf8');
setlocale(LC_NUMERIC, 'en_US.utf8');
date_default_timezone_set($def_cred->timezone);
?>
