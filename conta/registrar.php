<?php
define('INCL_FILE', 'true');
$def_printHTML = false;
require_once '../helper/ajaxRestriction.php';
require_once '../construct.php';

// Verifica se a criação de novas contas está ativada
if ($def_remainingTime) {
	$resultado = Usuario::registrar($_POST['usuario'], $_POST['senha'], null, true);
} else {
	$resultado = "c8";
}

echo $resultado ? notificacoes($resultado) : 0; // Imprime mensagem de erro caso tenha ocorrido alguma falha
?>
