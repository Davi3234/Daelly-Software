<?php
require_once '../model/Grupo.php';
require_once '../model/DaoGrupo.php';
require_once '../control/ControlGrupo.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlGrupo();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->inserir($_POST['numero'])) {
        $mensagem = "Grupo inserido com sucesso";
        unset($_POST);
    }
    if (count($control->getErros()) > 0) {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "header.php" ?>
    <title>Cadastro de Grupo - Daelly Confecções </title>
</head>

<body>
    <header id="header">
        <?php include "cabecalho.php" ?>
    </header>

    <main>
        <div id="barra-lateral">
            <?php include "barra-lateral.php" ?>
        </div>

        <div id="painel-comando">
            <div id="carregando">
                Carregando...
            </div>

            <div id="conteudo">
                <div class="conteudo-header">
                    <h2>Cadastro de Grupo</h2>
                </div>

                <?php if (isset($mensagem)) { ?>
                    <div class="alert alert-success">
                        <?php echo $mensagem; ?>
                        <div class="close-alert">X</div>
                    </div>
                <?php } ?>

                <?php if (isset($erros)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $erros; ?>
                        <div class="close-alert">X</div>
                    </div>
                <?php } ?>

                <div class="line-division"></div>

                <div class="conteudo-main">
                    <form action="" method="post" id="form">
                        <div class="actions-form">
                            <button type="submit" id="gravar" class="bt-action form primary">Gravar</button>
                            <button type="button" class="bt-action form primary voltar">Voltar</button>
                        </div>

                        <div class="line-division"></div>

                        <div class="fill-inputs">
                            <div class="input-box input-position-left">
                                <input type="text" name="numero" id="numero" required="required" autofocus="TRUE">
                                <label for="numero">Número*</label>
                                <i></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#i-grupo').addClass("active")
            $('#carregando').fadeOut();
            $('#conteudo').fadeIn();

            $(".voltar").click(function() {
                $(location).attr("href", "grupos.php");
            });
        });
    </script>
</body>

</html>