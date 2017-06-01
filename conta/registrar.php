<?php
define('INCL_FILE', 'true');
$def_printHTML = false;
require_once '../helper/ajaxRestriction.php';
require_once '../construct.php';

$resultado = Usuario::registrar($_POST['usuario'], $_POST['senha'], null, true);
echo $resultado ? notificacoes($resultado) : 0; // Imprime mensagem de erro caso tenha ocorrido alguma falha
?>
