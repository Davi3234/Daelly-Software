<?php
require_once '../model/MaquinaCostura.php';
require_once '../model/DaoMaquinaCostura.php';
require_once '../control/ControlMaquinaCostura.php';
require_once '../model/Manutencao.php';
require_once '../model/DaoManutencao.php';
require_once '../control/ControlManutencao.php';
require_once '../model/Compressor.php';
require_once '../model/DaoCompressor.php';
require_once '../control/ControlCompressor.php';
require_once '../model/MaquinaCosturaMapa.php';
require_once '../model/DaoMaquinaCosturaMapa.php';
require_once '../control/ControlMaquinaCosturaMapa.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlManutencao();
$controlMaq = new ControlMaquinaCostura();
$controlCom = new ControlCompressor();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->editar($_POST['descricao'], $_POST['data_manutencao'], $_POST['id_maquina_costura'], $_POST['id_compressor'], addslashes($_GET['id']))) {
        $mensagem = "Manutenção editada com sucesso";
        unset($_POST);
    }
    if (count($control->getErros()) > 0) {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$manutencao = $control->selecionar(addslashes($_GET['id']));
$maquina = $controlMaq->selecionar($manutencao->id_maquina_costura);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "head.php" ?>
    <title>Editar Manutenção - Daelly Conffecções</title>
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
                    <h2>Editar Manutenção</h2>
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
                                <input type="text" name="descricao" id="descricao" value="<?php echo $manutencao->descricao ?>" required="required" autofocus="TRUE">
                                <label for="descricao">Descrição</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <input type="date" name="data_manutencao" id="data_manutencao" value="<?php echo $manutencao->data_manutencao ?>" required="required" autofocus="TRUE">
                                <label for="data_manutencao">Data da Manutenção</label>
                                <i></i>
                            </div>
                            <div class="readonly input-position-left">
                                <label for="id_maquina_costura">Máquina de costura</label> <br>
                                <input type="text" readonly name="id_maquina_costura" id="id_maquina_costura" value="<?php echo $maquina->codigo . " - " . $maquina->tipo ?>" required="required" autofocus="TRUE">
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
            $('#i-manutencao').addClass("active")
            $('#carregando').fadeOut();
            $('#conteudo').fadeIn();

            $(".voltar").click(function() {
                $(location).attr("href", "manutencoes.php");
            });
        });
    </script>
</body>

</html>