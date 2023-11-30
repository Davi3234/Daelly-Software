<?php
require_once '../../model/MaquinaCostura.php';
require_once '../../model/DaoMaquinaCostura.php';
require_once '../../control/ControlMaquinaCostura.php';
require_once '../../model/MaquinaCosturaMapa.php';
require_once '../../model/DaoMaquinaCosturaMapa.php';
require_once '../../control/ControlMaquinaCosturaMapa.php';
require_once '../../model/Tipo.php';
require_once '../../model/DaoTipo.php';
require_once '../../control/ControlTipo.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlMaquinaCostura();
$controlTip = new ControlTipo();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->inserir($_POST['codigo'], $_POST['modelo'], $_POST['marca'], $_POST['chassi'], $_POST['aquisicao'], $_POST['id_tipo'])) {
        $mensagem = "Máquina de costura inserida com sucesso";
        unset($_POST);
    }
    if (count($control->getErros()) > 0) {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$tipos = $controlTip->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "header.php" ?>
    <title>Cadastro de Máquina de Costura - Daelly Conffecções</title>
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
                    <h2>Cadastro de Máquina de Costura</h2>
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
                            <a href="maquinas-costura.php" class="bt-action form primary icon-content rigth">Máquinas de Costura<span class="material-symbols-outlined">list</span></a>
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
                                <input value="<?php echo isset($_POST['modelo']) ? $_POST['modelo'] : "" ?>" type="text" name="modelo" id="modelo" required="required" autofocus="TRUE">
                                <label for="modelo">Modelo*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-left">
                                <input value="<?php echo isset($_POST['marca']) ? $_POST['marca'] : "" ?>" type="text" name="marca" id="marca" required="required" autofocus="TRUE">
                                <label for="marca">Marca*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <input value="<?php echo isset($_POST['chassi']) ? $_POST['chassi'] : "" ?>" type="text" name="chassi" id="chassi" required="required" autofocus="TRUE">
                                <label for="chassi">Chassi*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-left">
                                <input value="<?php echo isset($_POST['aquisicao']) ? $_POST['aquisicao'] : "" ?>" type="date" name="aquisicao" id="aquisicao" required="required" autofocus="TRUE">
                                <label for="aquisicao">Data de aquisição*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <select id="id_tipo" name="id_tipo">
                                    <option value="0">Selecione</option>
                                    <?php foreach ($tipos as $t) { ?>
                                        <option <?php if ((isset($_POST["id_tipo"]) && $_POST["id_tipo"] == $t->id)  || (isset($_GET["tipo"]) && $_GET["tipo"] == $t->id)) { ?> selected <?php } ?> value="<?php echo $t->id ?>"><?php echo $t->nome ?></option>
                                    <?php } ?>
                                </select>
                                <label for="id_tipo">Tipo*</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#i-maquina-costura').addClass("active")
        });
    </script>
</body>

</html>