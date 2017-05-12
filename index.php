<?php
define('INCL_FILE', 'true');
session_start();

if (empty($_SESSION['usuario'])) {

	// Importa página de login caso não esteja autenticado
    $def_navbar = false;
    require_once "construct.php";
    require_once "conta/login.php";
    exit();
} else {
    require_once "construct.php";
}
?>
