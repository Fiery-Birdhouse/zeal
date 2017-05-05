<?php
if (!defined(INCL_FILE)) die('HTTP/1.0 403 Forbidden');
?>

<style>
body {
    overflow: hidden;
	background: black;
}

#pagina {
	background: black;
}

#loginsegment {
    max-width: 30rem;
    margin: 0 auto;
    margin-top: 5%;
}
</style>

<div id="loginsegment">
    <br />
    <form class="ui inverted form" id="loginForm" method="POST">
        <img src='assets/z.png' style="width: 100%; height: auto;"/>
        <p>
          <div class="ui labeled fluid input">
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
        <button type="submit" class="ui submit <?= $def_secColorClass ?> inverted basic fluid button">Entrar</div>
    </form>
</div>

<script>
function submit() {
    $(".submit.button").addClass("loading");
    $("#loginForm").off("submit").on("submit", false);
    $.post("<?= $def_cred->rootURL ?>conta/autenticar.php", $("#loginForm").serializeArray(), function(response) {
        if (response != 0) {
            // Print error alert
            errorAlert(response);
        } else {
            $("#loginsegment").popup("hide");
            location.reload();
        }
	}).fail(function() {
        errorAlert("c0");
	}).always(function() {
        $(".submit.button").removeClass("loading");
        $("#loginForm").on("submit", submit);
    })
    // Prevent form from being submitted
    return false;
}

function errorAlert(erro) {
    $("#loginsegment").popup({
        on: "manual",
        position: "bottom center",
        variation: "inverted",
        content: erro
    }).popup("show");
}
$("#loginForm").on("submit", submit);
</script>
