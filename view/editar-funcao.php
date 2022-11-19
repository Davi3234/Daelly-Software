<?php
require_once '../model/Funcao.php';
require_once '../model/DaoFuncao.php';
require_once '../control/ControlFuncao.php';
require_once '../model/Tipo.php';
require_once '../model/DaoTipo.php';
require_once '../control/ControlTipo.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlFuncao();
$controlTip = new ControlTipo();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->editar($_POST['nome'], $_POST['id_tipo'], addslashes($_GET['id']))) {
        $mensagem = "Função editada com sucesso";
        unset($_POST);
    }
    if (count($control->getErros()) > 0) {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$funcao = $control->selecionar(addslashes($_GET['id']));
$tipo = $controlTip->selecionar($funcao->id_tipo);
$tipos = $controlTip->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "header.php" ?>
    <title>Editar Função - Daelly Conffecções</title>
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
            <div id="carregando">
                Carregando...
            </div>

            <div class="conteudo">
                <div class="conteudo-header">
                    <h2>Editar Função</h2>
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
                            <a href="funcoes.php" class="bt-action form primary icon-content rigth">Funções<span class="material-symbols-outlined">list</span></a>
                            <button type="button" class="bt-action form primary voltar icon-content rigth">Voltar<span class="material-symbols-outlined">redo</span></button>
                        </div>

                        <div class="line-division"></div>

                        <div class="fill-inputs">
                            <div class="input-box input-position-left">
                                <input type="text" name="nome" id="nome" value="<?php echo $funcao->nome ?>" required="required" autofocus="TRUE">
                                <label for="nome">Nome*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <select id="id_tipo" name="id_tipo">
                                    <option value="0">Selecione</option>
                                    <?php foreach ($tipos as $t) {
                                        if ($t->nome == $tipo->nome) {
                                    ?>
                                            <option selected value="<?php echo $t->id ?>"><?php echo $t->nome ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $t->id ?>"><?php echo $t->nome ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <label for="id_tipo">Tipo</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#i-funcao').addClass("active")
            $('#carregando').fadeOut();
            $('.conteudo').fadeIn();

            $(".voltar").click(function() {
                $(location).attr("href", "funcoes.php");
            });
        });
    </script>
</body>

</html>