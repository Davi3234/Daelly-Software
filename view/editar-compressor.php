<?php
require_once '../model/Compressor.php';
require_once '../model/DaoCompressor.php';
require_once '../control/ControlCompressor.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlCompressor();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->editar($_POST['codigo'], $_POST['marca'], $_POST['modelo'], addslashes($_GET['id']))) {
        $mensagem = "Compressor editado com sucesso";
        unset($_POST);
    }
    if (count($control->getErros()) > 0) {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$compressor = $control->selecionar(addslashes($_GET['id']));
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "head.php" ?>
    <title>Editar Compressor - Daelly Confeções</title>
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
                    <h2>Editar Compressor</h2>
                </div>

                <?php if (isset($mensagem)) { ?>
                    <div class="alert alert-success">
                        <?php echo $mensagem; ?>
                    </div>
                <?php } ?>

                <?php if (isset($erros)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $erros; ?>
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
                                <input type="text" name="codigo" id="codigo" value="<?php echo $compressor->codigo ?>" required="required" autofocus="TRUE">
                                <label for="codigo">Código</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <input type="text" name="marca" id="marca" value="<?php echo $compressor->marca ?>" required="required" autofocus="TRUE">
                                <label for="marca">Marca</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <input type="text" name="modelo" id="modelo" value="<?php echo $compressor->modelo ?>" required="required" autofocus="TRUE">
                                <label for="modelo">Modelo</label>
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
            $('#i-compressor').addClass("active")
            $('#carregando').fadeOut();
            $('#conteudo').fadeIn();

            $(".voltar").click(function() {
                $(location).attr("href", "compressores.php");
            });
        });
    </script>
</body>

</html>