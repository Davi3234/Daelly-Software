<?php
require_once '../../model/MaquinaCostura.php';
require_once '../../model/DaoMaquinaCostura.php';
require_once '../../control/ControlMaquinaCostura.php';
require_once '../../model/Manutencao.php';
require_once '../../model/DaoManutencao.php';
require_once '../../control/ControlManutencao.php';
require_once '../../model/Compressor.php';
require_once '../../model/DaoCompressor.php';
require_once '../../control/ControlCompressor.php';
require_once '../../model/MaquinaCosturaMapa.php';
require_once '../../model/DaoMaquinaCosturaMapa.php';
require_once '../../control/ControlMaquinaCosturaMapa.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlManutencao();
$controlMaq = new ControlMaquinaCostura();
$controlCom = new ControlCompressor();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->editar($_POST['descricao'], $_POST['data_manutencao'], addslashes($_GET['id']))) {
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

$maquinas = $controlMaq->listar();
$compressores = $controlCom->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "header.php" ?>
    <title>Editar Manutenção - Daelly Conffecções</title>
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
                    <h2>Editar Manutenção</h2>
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
                            <a href="manutencoes.php" class="bt-action form primary icon-content rigth">Manutenções<span class="material-symbols-outlined">list</span></a>
                            <button type="button" class="bt-action form primary voltar icon-content rigth">Voltar<span class="material-symbols-outlined">redo</span></button>
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
                            <div class="input-box input-position-left" style="margin-top: .15rem;">
                                <select disabled class="component-polimorph" onchange="changeSelectPolimorph(event)" id="id_maquina_costura" name="id_maquina_costura">
                                    <option value="0">Selecione</option>
                                    <?php foreach ($maquinas as $m) {
                                    ?>
                                        <option <?php if ($manutencao->id_maquina_costura && $m->id == $manutencao->id_maquina_costura) { ?> selected <?php }?> value="<?php echo $m->id ?>"><?php echo $m->tipo . " - " . $m->codigo ?></option>
                                    <?php } ?>
                                </select>
                                <label for="id_maquina_costura">Máquinas de Costura</label>
                            </div>
                            <div class="input-box input-position-right">
                                <select disabled class="component-polimorph" onchange="changeSelectPolimorph(event)" id="id_compressor" name="id_compressor">
                                    <option value="0">Selecione</option>
                                    <?php foreach ($compressores as $c) {
                                    ?>
                                        <option <?php if ($manutencao->id_compressor && $c->id == $manutencao->id_compressor) { ?> selected <?php }?> value="<?php echo $c->id ?>"><?php echo $c->codigo ?></option>
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