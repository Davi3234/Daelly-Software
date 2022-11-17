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
    if ($control->inserir($_POST['descricao'], $_POST['data_manutencao'], $_POST['id_maquina_costura'], $_POST['id_compressor'])) {
        $mensagem = "Manutenção inserida com sucesso";
        unset($_POST);
    }
    if (count($control->getErros()) > 0) {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$maquinas = $controlMaq->listar();
$compressores = $controlCom->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "header.php" ?>
    <title>Cadastro Manutenção - Daelly Confecções</title>
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
                    <h2>Cadastro de Manutenção</h2>
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
                            <button type="submit" id="gravar" class="bt-action form primary">Gravar</button>
                            <button type="button" class="bt-action form primary voltar">Voltar</button>
                        </div>

                        <div class="line-division"></div>

                        <div class="fill-inputs">
                            <div class="input-box input-position-left" style="margin-top: .2rem;">
                                <input value="<?php echo isset($_POST['descricao']) ? $_POST['descricao'] : "" ?>" type="text" name="descricao" id="descricao" required="required" autofocus="TRUE">
                                <label for="descricao">Descrição*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <input value="<?php echo isset($_POST['data_manutencao']) ? $_POST['data_manutencao'] : "" ?>" type="date" name="data_manutencao" id="data_manutencao" required="required" autofocus="TRUE">
                                <label for="data_manutencao">Data da manutenção*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-left" style="margin-top: .15rem;">
                                <select class="component-polimorph" onchange="changeSelectPolimorph(event)" id="id_maquina_costura" name="id_maquina_costura">
                                    <option value="0">Selecione</option>
                                    <?php foreach ($maquinas as $m) {
                                    ?>
                                        <option <?php if (isset($_POST["id_maquina_costura"]) && $_POST["id_maquina_costura"] == $m->id) { ?> selected <?php } ?> value="<?php echo $m->id ?>"><?php echo $m->tipo . " - " . $m->codigo ?></option>
                                    <?php } ?>
                                </select>
                                <label for="id_maquina_costura">Máquinas de Costura</label>
                            </div>
                            <div class="input-box input-position-right">
                                <select class="component-polimorph" onchange="changeSelectPolimorph(event)" id="id_compressor" name="id_compressor">
                                    <option value="0">Selecione</option>
                                    <?php foreach ($compressores as $c) {
                                    ?>
                                        <option <?php if (isset($_POST["id_compressor"]) && $_POST["id_compressor"] == $c->id) { ?> selected <?php } ?> value="<?php echo $c->id ?>"><?php echo $c->codigo ?></option>
                                    <?php } ?>
                                </select>
                                <label for="id_compressor">Compressor</label>
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

        function changeSelectPolimorph({
            target
        }) {
            document.querySelectorAll(".component-polimorph").forEach(c => {
                if (c.name == target.name) {
                    return
                }
                c.value = 0
            })
        }
    </script>
</body>

</html>