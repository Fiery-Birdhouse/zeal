<?php
if (!defined(INCL_FILE)) die('HTTP/1.0 403 Forbidden');
$D = floor($def_remainingTime / (3600 * 24));
$H = floor($def_remainingTime / 3600 % 24);
$M = floor($def_remainingTime / 60 % 60);
$S = floor($def_remainingTime % 60);
$format = sprintf('%02d:%02d:%02d:%02d', $D, $H, $M, $S);
?>

<style>
body, #pagina {
	background: black;
}

#loginsegment {
	max-width: 30rem;
	margin: 0 auto;
}

#timer {
	margin-bottom: 22%;
	margin-top: -30%;
	font-family: digital7;
	mix-blend-mode: color-dodge;
	color: <?= $def_secColor ?>;
}
</style>

<div id="loginsegment">
	<br />
	<form class="ui inverted form" id="loginForm" method="POST">
		<img src='assets/z.png' style="width: 100%; height: auto;"/>
		<p>
		  <?= $def_remainingTime ? "<div class='ui center aligned header' id='timer'>$format</div>" : "" ?>
		  <div class="ui labeled fluid input" id="campoUsuario">
			<div class="ui <?= $def_secColorClass ?> label" style="width: 5rem;">
			  <center>Usuário</center>
			</div>
			<input name="usuario" type="text">
		  </div>
		</p>
		<p>
		  <div class="ui labeled fluid input">
			<div class="ui <?= $def_secColorClass ?> label" style="width: 5rem;">
			  <center>Senha</center>
			</div>
			<input name="senha" type="password">
		  </div>
		</p>
		<div class="ui fluid <?= $def_secColorClass ?> inverted basic buttons">
			<button class="ui button" id="botaoEntrar">Entrar</button>
			<?= $def_remainingTime ? "<button class='ui button' id='botaoRegistrar'>Registrar-se</button>" : "" ?>
		</div>

		<div class="ui horizontal inverted divider">Ou</div>

		<button class="ui fluid inverted <?= $def_secColorClass ?> button" id="botaoFacebook">
			<i class="facebook icon"></i>Entrar com Facebook
		</button>
	</form>
</div>

<script>
<?php if ($def_remainingTime) { ?>
function countdown(intervalo, update, complete) {
	var timeNow = <?= $def_remainingTime ?>;
	var interval = setInterval(function() {
		timeNow--;

		if (timeNow <= 0) {
			clearInterval(interval);
			complete();
		} else {
			update(timeNow);
		}
	}, intervalo);
};

countdown(
	1000,
	function(timeLeft) {
		("0" + Math.floor(timeLeft/60/60/24)).slice(-2)
		D = ("0" + Math.floor(timeLeft / (24 * 60 * 60))).slice(-2);
		H = ("0" + Math.floor(timeLeft / (60 * 60) % 24)).slice(-2);
		M = ("0" + Math.floor(timeLeft / 60 % 60)).slice(-2);
		S = ("0" + Math.floor(timeLeft % 60)).slice(-2);

		$("#timer").text(D + ':' + H + ':' + M + ':' + S);
	},
	function() {
		$("#timer, #botaoRegistrar").remove();
	}
);

<?php } ?>

function submit() {
	$("#botaoEntrar").addClass("loading");
	$("#loginForm").off("submit").on("submit", false);
	$.post("<?= $def_cred->rootURL ?>conta/autenticar.php", $("#loginForm").serializeArray(), function(response) {
		if (response != 0) {
			errorAlert(response);
		} else {
			location.reload();
		}
	}).fail(function() {
		errorAlert("z0");
	}).always(function() {
		$("#botaoEntrar").removeClass("loading");
		$("#loginForm").on("submit", submit);
	})
	return false;
}

function errorAlert(erro) {
	$("#campoUsuario").popup({
		on: "manual",
		position: "top center",
		variation: "inverted",
		content: erro
	}).popup("show");
}

$("#botaoEntrar").on("click", submit);
</script>
