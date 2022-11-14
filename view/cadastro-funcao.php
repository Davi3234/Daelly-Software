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
    if ($control->inserir($_POST['nome'], $_POST['id_tipo'])) {
        $mensagem = "Função inserida com sucesso";
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
    <?php include "head.php" ?>
    <title>Cadastro de Função - Daelly Conffecções</title>
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
                    <h2>Cadastro de Função</h2>
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
                                <input type="text" name="nome" id="nome" required="required" autofocus="TRUE">
                                <label for="nome">Nome*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <select class="form-control" id="id_tipo" name="id_tipo">
                                    <option value="0">Selecione</option>
                                    <?php foreach ($tipos as $t) { ?>
                                        <option value="<?php echo $t->id ?>"><?php echo $t->nome ?></option>
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
            $('#conteudo').fadeIn();

            $(".voltar").click(function() {
                $(location).attr("href", "funcoes.php");
            });
        });
    </script>
</body>

</html>