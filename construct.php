<?php
if (!defined(INCL_FILE)) die('HTTP/1.0 403 Forbidden');
header ('Content-type: text/html; charset=UTF-8');

require_once __DIR__ . '/helper/debug.php';
require_once __DIR__ . '/autoload.php';

if (!isset($_SESSION)) {
	session_start();
}

# Definições padrões.
$def_navbar = isset($def_navbar) ? $def_navbar : true; // Define se a barra de navegação deve ser adicionada na construção base da página
$def_printHTML = isset($def_printHTML) ? $def_printHTML : true; // Define se este arquivo deve imprimir estrutura básica do site
$def_remainingTime = time() < $def_cred->endTime ? $def_cred->endTime - time() : false; // Tempo restante para finalizar período de registro
$def_navOption = isset($def_navOption) ? $def_navOption : "home";

if (empty($def_secColorClass)) {
	$def_secColorClass = date('H') >= 6 && date('H') <= 18 ? 'red' : 'violet';
}

if (empty($def_secColor)) {
	$def_secColor = date('H') >= 6 && date('H') <= 18 ? '#ff0000' : '#6B0CFB';
}

if ($def_printHTML) {
?>

<html>
	<head>
		<title>Zeal</title>

		<link rel="stylesheet" type="text/css" href="<?= $def_cred->rootURL ?>assets/css/semantic.css" />
		<link rel="stylesheet" type="text/css" href="<?= $def_cred->rootURL ?>assets/css/style.css" />

		<script src="<?= $def_cred->rootURL ?>assets/js/jquery.js"></script>
		<script src="<?= $def_cred->rootURL ?>assets/js/semantic.js"></script>
		<script src="<?= $def_cred->rootURL ?>assets/js/loadingScreen.js"></script>

		<style>
		.navoption {
			color: <?= $def_secColor ?> !important;
		}
		</style>

		<script type="text/javascript">
			if (window.location.hash && window.location.hash == '#_=_') {
				if (window.history && history.pushState) {
					window.history.pushState("", document.title, window.location.pathname);
				}
			}
		</script>
	</head>

	<body>
		<?php if ($def_navbar) { ?>
		<div class="ui vertical inverted sidebar labeled icon menu" id="sidebar">
			<a class="item home" href='<?= $def_cred->rootURL ?>'>
				<i class="home icon"></i>
				Início
			</a>
			<a class="item livros" href="<?= $def_cred->rootURL ?>livros/">
				<i class="Book icon"></i>
				Livros
			</a>
			<a class="item duvidas">
				<i class="Help Circle icon"></i>
				Dúvidas
			</a>
			<a class="item conversa">
				<i class="Comments icon"></i>
				Conversa
			</a>
			<a class="item" href="<?= $def_cred->rootURL ?>conta/sair.php">
				<i class="Sign Out icon"></i>
				Sair
			</a>
		</div>
		<?php } ?>

		<div class="ui fluid container">
			<div class="ui segment inverted" id="pagina">
				<?php if ($def_navbar) { ?>
				<button class="ui <?= $def_secColorClass ?> big right attached icon button" id="menulauncher">
				  <i class="content icon"></i>
				</button>

				<script>
				$('#sidebar').sidebar({
					'transition': 'overlay',
					onChange : function() {
					  $("#menulauncher").transition('browse right');
					}
				}).sidebar('attach events', '#menulauncher');

				$(".<?= $def_navOption ?>").addClass("navoption");
				</script>
				<?php } ?>
<?php
}
?>
