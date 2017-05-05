<?php
define('INCL_FILE', 'true');
require_once '../helper/ajaxRestriction.php';
$def_printHTML = false;
require_once '../construct.php';

$resultado = Usuario::logar($_POST['usuario'], $_POST['senha']);

echo $resultado ? notificacoes($resultado) : 0; // Imprime mensagem de erro caso tenha ocorrido alguma falha
?>
