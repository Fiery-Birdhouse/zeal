<?php
if (!defined(INCL_FILE)) die('HTTP/1.0 403 Forbidden');
?>

<style>
body {
    overflow: hidden;
}
#loginsegment {
    max-width: 30rem;
    margin: 0 auto;
    margin-top: 10%;
}
</style>

<div id="loginsegment">
    <br />
    <form class="ui inverted form" id="loginForm" method="POST">
        <h1 class="ui inverted center aligned header" style="font-size: 50px;">
            <i class="book icon"></i> Zeal
        </h1>
        <p>
          <div class="ui labeled fluid input">
            <div class="ui <?= $def_secColorClass ?> label" style="width: 5rem;">
              Usuário
            </div>
            <input type="text">
          </div>
        </p>
        <p>
          <div class="ui labeled fluid input">
            <div class="ui <?= $def_secColorClass ?> label" style="width: 5rem;">
              Senha
            </div>
            <input type="password">
          </div>
        </p>
        <button type="submit" class="ui submit red inverted basic fluid button">Entrar</div>
    </form>
</div>

<script>
function submit() {
    $(".submit.button").addClass("loading");
    $("#loginForm").off("submit").on("submit", false);
    $.post("<?= $def_cred->rootURL ?>account/createsession.php", $("#loginForm").serializeArray(), function(response) {
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
function errorAlert(id) {
    $("#loginsegment").popup({
        on: "manual",
        position: "bottom center",
        variation: "inverted",
        content: getErrorMessage(id)
    }).popup("show");
}
$("#loginForm").on("submit", submit);
</script>
