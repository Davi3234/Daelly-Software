<?php
require_once '../../model/Compressor.php';
require_once '../../model/DaoCompressor.php';
require_once '../../control/ControlCompressor.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlCompressor();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->inserir($_POST['codigo'], $_POST['marca'], $_POST['modelo'],)) {
        $mensagem = "Compressor inserido com sucesso";
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
    <title>Cadastro de Compressor - Daelly Confecções</title>
</head>

<body>
    <header>
        <?php include "cabecalho.php" ?>
    </header>

    <main>
        <div id="barra-lateral">
            <?php include "barra-lateral.php" ?>
        </div>

        <div id="painel-comando">
            <div class="carregando">
                Carregando...
            </div>

            <div class="conteudo">
                <div class="conteudo-header">
                    <h2>Cadastro de Compressor</h2>
                </div>

                <?php if (isset($mensagem)) { ?>
                    <div class="alert alert-success">
                        <?php echo $mensagem; ?>
                        <div class="close-alert material-symbols-outlined">close</div>
                    </div>
                <?php } ?>

                <?php if (isset($erros)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $erros; ?>
                        <div class="close-alert material-symbols-outlined">close</div>
                    </div>
                <?php } ?>

                <div class="line-division"></div>

                <div class="conteudo-main">
                    <form action="" method="post" id="form">
                        <div class="actions-form">
                            <button type="submit" id="gravar" class="bt-action form primary icon-content rigth">Gravar<span class="material-symbols-outlined">done</span></button>
                            <a href="compressores.php" class="bt-action form primary icon-content rigth">Compressores<span class="material-symbols-outlined">list</span></a>
                            <button type="button" class="bt-action form primary voltar icon-content rigth">Voltar<span class="material-symbols-outlined">redo</span></button>
                        </div>

                        <div class="line-division"></div>

                        <div class="fill-inputs">
                            <div class="input-box input-position-left">
                                <input value="<?php echo isset($_POST['codigo']) ? $_POST['codigo'] : "" ?>" type="number" name="codigo" id="codigo" required="required" autofocus="TRUE">
                                <label for="codigo">Código*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <input value="<?php echo isset($_POST['marca']) ? $_POST['marca'] : "" ?>" type="text" name="marca" id="marca" required="required" autofocus="TRUE">
                                <label for="marca">Marca*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-left">
                                <input value="<?php echo isset($_POST['modelo']) ? $_POST['modelo'] : "" ?>" type="text" name="modelo" id="modelo" required="required" autofocus="TRUE">
                                <label for="modelo">Modelo*</label>
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
        });
    </script>
</body>

</html>