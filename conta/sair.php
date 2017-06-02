<?php
define('INCL_FILE', 'true');
$def_navbar = false;
require_once "../construct.php";

unset($_SESSION);
session_destroy();
header('Location: ' . $def_cred->rootURL);
die();
?>
