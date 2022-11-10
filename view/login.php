<?php
session_start();
if (isset($_SESSION["email"])) {
    header("location: painel.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'header.php' ?>
    <style>
        #erro {
            display: none;
        }

        #carregando {
            display: none;
        }
    </style>
</head>

<body>
    <div id="img">
        <img src="../assets/imgs/Malharia.jpeg" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div id="carregando">
                Efetuando login...
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">

                    <div class="panel-body">
                        <div class="titulo">Acesse sua conta</div>
                        <div class="iconmelon">
                            <img src="/img/logo.png" width="180">
                        </div>
                        <form method="POST">
                            <div class="alert alert-info">
                                Informe seus dados de login
                            </div>
                            <div id="erro" class="alert alert-danger">

                            </div>
                            <fieldset>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" name="email" id="email" type="email" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" id="senha" name="senha" class="form-control" id="floatingPassword" required="required" placeholder="Informe seu email">
                                    <label for="floatingPassword">Senha</label>
                                </div>
                                <div class="form-group">
                                    <button id="logar" class="btn btn-block btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Entrar</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("body").css("padding-top", ($(window).height() - $(".login-panel").height()) / 2);
        });


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