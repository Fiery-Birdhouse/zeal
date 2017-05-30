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
	margin-bottom: 24%;
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

<div class="ui basic modal" id="modalRegistrar">
	<div class="header">
		<i class="Add User icon"></i> Preencha os campos abaixo
	</div>

	<div class="content">
		<div class="description fluid">
			<form class="ui inverted form" id="registroForm" method="POST">
				<div class="fields fluid">
					<div class="eight wide field">
						<label>Usuário</label>
						<input type="text" name="usuario" maxlength="45" placeholder="Usuário" />
					</div>
				</div>

				<p>
					<div class="fields fluid">
						<div class="eight wide field">
							<label>Senha</label>
							<input type="password" name="senha" maxlength="45" placeholder="Senha" id="campoRegSenha" />
						</div>

						<div class="eight wide field">
							<label>Confirmar senha</label>
							<input type="password" name="confSenha" maxlength="45" placeholder="Senha" />
						</div>
					</div>
				</p>
			</form>
		</div>
	</div>

	<div class="actions">
		<div class="two ui inverted buttons">
			<div class="ui cancel red basic inverted button">
				<i class="remove icon"></i>
				Cancelar
			</div>

			<div class="ui ok green basic inverted button" id="enviaRegistro">
				<i class="checkmark icon"></i>
				Feito
			</div>
		</div>
	</div>
</div>

<script>
function submitLogin() {
	$("#botaoEntrar").addClass("loading");
	$("#loginForm").off("submit").on("submit", false);
	$(".button").addClass("disabled");

	$.post("<?= $def_cred->rootURL ?>conta/autenticar.php", $("#loginForm").serializeArray(), function(response) {
		if (response != 0) {
			errorAlert(response, "campoUsuario");
		} else {
			location.reload();
		}
	}).fail(function() {
		errorAlert("Não foi possível se conectar ao servidor", "campoUsuario");
	}).always(function() {
		$("#botaoEntrar").removeClass("loading");
		$("#loginForm").on("submit", submitLogin);
		$(".button").removeClass("disabled");
	})
	return false;
}

function submitRegistro() {
	$("#enviaRegistro").addClass("loading");
	$(".button").addClass("disabled");

	var dados = $("#registroForm").serializeArray();
	var success = false;
	var errorMessage = false;

	for (var campo in dados) {
		if (dados.hasOwnProperty(campo)) {
			var valor = dados[campo]['value'];
			var nome = dados[campo]['name'];

			if (valor == "") {
				errorMessage = "Por favor, preencha todos os campos";
				break;
			} else if (nome == "usuario" && (valor.length < 3 || valor.length > 32)) {
				errorMessage = "O nome de usuário deve conter entre 3 e 32 caracteres";
				break;
			} else if (nome == "senha" && valor.length < 8) {
				errorMessage = "A senha deve conter no mínimo 8 caracteres";
				break;
			} else if (nome == "confSenha" && valor !== $("#campoRegSenha").val()) {
				errorMessage = "As senhas não coincidem";
				break;
			}
		}
	}

	if (!errorMessage) {
		$.post("<?= $def_cred->rootURL ?>conta/registrar.php", dados, function(response) {
			if (response != 0) {
				errorAlert(response, "modalRegistrar", "bottom center");
			} else {
				location.reload();
			}
		}).fail(function() {
			errorAlert("Não foi possível se conectar ao servidor", "modalRegistrar");
		}).always(function() {
			$("#enviaRegistro").removeClass("loading");
			$(".button").removeClass("disabled");
		})
	} else {
		errorAlert(errorMessage, "modalRegistrar", "bottom center");
		$("#enviaRegistro").removeClass("loading");
		$(".button").removeClass("disabled");
	}

	return success;
}

function errorAlert(erro, id, position) {
	var position = typeof position === 'undefined' ? "top center" : position;

	$("#" + id).popup({
		on: "manual",
		position: position,
		variation: "inverted",
		content: erro
	}).popup("show");
}

$("#loginForm").on("submit", submitLogin);

$('#modalRegistrar').modal({
	onApprove: submitRegistro,
	onVisible: function() {
		$(".popup").popup("hide all");
	},
	onHide: function() {
		$(".popup").popup("hide all");
	}
});
$("#botaoRegistrar, #botaoFacebook").on("click", function() {
	$('#modalRegistrar').modal('show');
	$(".popup").popup("hide all");
	return false;
});

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
</script>
