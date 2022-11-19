<?php
session_start();
if (isset($_SESSION["email"])) {
    header("location: painel.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "header.php" ?>
    <title>Acesso ao Sistema - Daelly Conffecções</title>
    <style>
        .carregando,
        #erro {
            display: none;
        }
    </style>
</head>

<body>
    <div class="bg-image"></div>
    <div class="carregando">
        Efetuando acesso...
    </div>

    <div class="session-login">
        <form class="login-content" action="" method="post">
            <div class="form-header">
                <h1>Acesso ao Sistema</h1>
            </div>

            <div id="erro" class="alert alert-danger"></div>

            <div class="fill-inputs" style="margin-top: 2rem;">
                <div class="input-box">
                    <input type="email" name="email" id="email" required="required" autofocus="TRUE">
                    <label for="email">Email</label>
                    <i></i>
                </div>
                <div class="input-box">
                    <input type="password" name="senha" id="senha" required="required">
                    <label for="senha">Senha</label>
                    <i></i>
                </div>
            </div>

            <div class="actions-form">
                <button type="submit" id="logar" class="bt-action form primary icon-content rigth">Entrar<span class="material-symbols-outlined">login</span></button>
            </div>
        </form>
    </div>

    <script>
        $("#logar").click(function() {
            $('.carregando').fadeIn();
            var email = $("#email").val();
            var senha = $("#senha").val();
            $.ajax({
                url: '/ajax/login.php',
                dataType: 'text',
                data: {
                    email: email,
                    senha: senha
                },
                type: 'POST',
                success: function(resposta) {
                    $('.carregando').fadeOut();
                    if (resposta) {
                        $("#erro").html(resposta);
                        $("#erro").css("display", "block");
                        $("body").css("padding-top", ($(window).height() - $(".login-panel").height()) / 2);
                    } else {
                        $(location).attr("href", "/view/painel.php");
                    }
                }
            });
            return false;
        });
    </script>
</body>

</html>