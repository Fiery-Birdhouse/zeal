<?php
define('INCL_FILE', 'true');
require_once '../helper/ajaxRestriction.php';
$def_printHTML = false;
require_once '../construct.php';

echo Usuario::logar($_POST['usuario'], $_POST['senha']);
?>
