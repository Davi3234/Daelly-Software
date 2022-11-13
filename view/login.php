<?php
session_start();
if (isset($_SESSION["email"])) {
    header("location: painel.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso ao Sistema</title>
    <link rel="stylesheet" href="../css/GlobalStyles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="/js/jquery-3.1.0.min.js"></script>

    <style>
        #carregando,
        #erro {
            display: none;
        }
    </style>
</head>

<body style="padding-top: 5rem;">
    <div id="carregando" style="margin-top: 0;">
        Efetuando login...
    </div>

    <div class="session-login">
        <form class="login-content" action="" method="post">
            <div class="form-header">
                <h1>Login</h1>
            </div>

            <div id="erro" class="alert alert-danger"></div>

            <div class="fill-inputs login" style="margin-top: 2rem;">
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
                <button type="submit" id="logar" class="bt-action form primary">Logar</button>
            </div>
        </form>
    </div>

    <script>
        $("#logar").click(function() {
            $('#carregando').fadeIn();
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
                    $('#carregando').fadeOut();
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