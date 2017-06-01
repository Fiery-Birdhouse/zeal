function atualizarLoadingScreen() {
	// Verifica se o dimmer está aberto
	if ($("#dimmerLoadingScreen").dimmer("is active") || $("#dimmerLoadingScreen").dimmer("is animating")) {
		// Lista de mensagens
		var lsMensagens = [
			"Girando manivelas",
			"Ligando servidores",
			"Girando válvulas",
			"Trocando óleo das máquinas",
			"Adicionando carvão às máquinas",
			"Trocando cabos",
			"Trocando parafusos",
			"Processando dados",
			"Montando quebra-cabeça",
			"Resolvendo cubo mágico",
			"Alimentando os hamsters"
		];

		// Contador de pontos
		var pontos = $("#pontosLoadingScreen").html();

		// Atualiza e limita o tempo para alterar mensagem
		lsTempo = (typeof lsTempo === 'undefined' || lsTempo >= 15) ? 0 : lsTempo + 1;

		// Adiciona novos pontos
		if (pontos.length >= 3) {
			$("#pontosLoadingScreen").html("");
		} else {
			$("#pontosLoadingScreen").html(pontos + ".");
		}

		// Atualiza mensagem
		if (lsTempo == 0) {
			var indiceMensagem = Math.floor((Math.random() * lsMensagens.length));
			$("#mensagemLoadingScreen").html(lsMensagens[indiceMensagem]);
		}

		// Repete o processo a cada 1 segundo
		setTimeout(atualizarLoadingScreen, 1000);
	}
}

function mostrarLoadingScreen() {
	construirLoadingScreen();
	$("#dimmerLoadingScreen").dimmer("show");
	atualizarLoadingScreen();
}

function esconderLoadingScreen() {
	delete lsTempo;
	$("#dimmerLoadingScreen").dimmer("hide");
}

function construirLoadingScreen() {
	// Se o modal não foi construído
	if (!$("#dimmerLoadingScreen").length) {
		item = $('<div/>', {
			class: "ui page dimmer",
			id: "dimmerLoadingScreen"
		});
		$("body").append(item);

		item = $('<div/>', {
			class: "content"
		});
		$("#dimmerLoadingScreen").append(item);

		item = $('<h2/>', {
			class: "ui inverted icon header"
		});
		$("#dimmerLoadingScreen .content").append(item);

		$("#dimmerLoadingScreen .content .header").html(
			'<div class="ui text"><i class="spinner loading icon"></i> Por favor, aguarde</div> \
			<div class="sub header"><span id="mensagemLoadingScreen"></span><span id="pontosLoadingScreen" style="position: absolute;"></span></div>');
	}
}
