<?php
require_once '../model/Funcionario.php';
require_once '../model/DaoFuncionario.php';
require_once '../control/ControlFuncionario.php';
require_once '../model/FuncionarioFuncao.php';
require_once '../model/DaoFuncionarioFuncao.php';
require_once '../control/ControlFuncionarioFuncao.php';
require_once '../model/Grupo.php';
require_once '../model/DaoGrupo.php';
require_once '../control/ControlGrupo.php';
require_once '../model/Funcao.php';
require_once '../model/DaoFuncao.php';
require_once '../control/ControlFuncao.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlFuncionario();
$controlGru = new ControlGrupo();
$controlFun = new ControlFuncao();
$controlFF = new ControlFuncionarioFuncao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $funcoesSelecionadas = json_decode($_POST["funcoes-selecionadas"])->funcoes;

    if ($control->editar($_POST['cpf'], $_POST['nome'], $_POST['entrada'], $_POST['saida'], $_POST['id_grupo'], addslashes($_GET['id']))) {
        $mensagem = "Funcionário editado com sucesso";

        $control->vincularFuncoes($control->selecionarByCpf($_POST["cpf"], $funcoesSelecionadas)->id, $funcoesSelecionadas);
    }
    if (count($control->getErros()) > 0) {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    } else {
        unset($_POST);
    }
}
$listaGru = $controlGru->listar();
$listaFun = $controlFun->listar();
$listaFuncaInFunci = array();
foreach ($controlFF->listarByFuncionario(addslashes($_GET['id'])) as $f) {
    $listaFuncaInFunci[] = $f['id_funcao'];
}

$funcionario = $control->selecionar(addslashes($_GET['id']));

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "header.php" ?>
    <title>Cadastro de Funcionário - Daelly Conffecções</title>
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
                    <h2>Cadastro de Funcionário</h2>
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
                        <input type="hidden" name="funcoes-selecionadas" id="funcoes-input" value='{"funcoes":[]}'>

                        <div class="actions-form">
                            <button type="submit" id="gravar" class="bt-action form primary icon-content rigth">Gravar<span class="material-symbols-outlined">done</span></button>
                            <a href="funcionarios.php" class="bt-action form primary icon-content rigth">Funcionários<span class="material-symbols-outlined">list</span></a>
                            <button type="button" class="bt-action form primary voltar icon-content rigth">Voltar<span class="material-symbols-outlined">redo</span></button>
                        </div>

                        <div class="line-division"></div>

                        <div class="fill-inputs">
                            <div class="input-box input-position-left" style="margin-top: .2rem;">
                                <input type="text" name="nome" id="nome" required="required" autofocus="TRUE" value="<?php echo $funcionario->nome ?>">
                                <label for="nome">Nome*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <input type="date" name="entrada" id="entrada" required="required" value="<?php echo $funcionario->entrada ?>">
                                <label for="entrada">Entrada*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-left" style="margin-top: .2rem;">
                                <input type="text" name="cpf" id="cpf" required="required" value="<?php echo $funcionario->cpf ?>">
                                <label for="cpf">CPF*</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-right">
                                <input type="date" name="saida" id="saida" value="<?php echo $funcionario->saida ?>">
                                <label for="saida">Saída</label>
                                <i></i>
                            </div>
                            <div class="input-box input-position-left">
                                <select id="id_grupo" name="id_grupo">
                                    <option value="0">Selecione</option>
                                    <?php foreach ($listaGru as $g) { ?>
                                        <option <?php if ($funcionario->id_grupo == $g->id) { ?> selected <?php } ?> value="<?php echo $g->id ?>"><?php echo $g->numero ?></option>
                                    <?php } ?>
                                </select>
                                <label for="id_grupo">Grupo</label>
                                <i></i>
                            </div>
                            <fieldset class="input-box input-position-right checkbox">
                                <legend>Funções</legend>
                                <?php foreach ($listaFun as $f) { ?>
                                    <div class="checkbox-box">
                                        <input <?php if (in_array($f->id, $listaFuncaInFunci)) { ?> checked <?php } ?> name="funcoes[]" type="checkbox" value="<?php echo $f->id ?>" id="flexCheckDefault">
                                        <label for="flexCheckDefault"><?php echo $f->nome ?></label>
                                    </div>
                                <?php } ?>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#i-funcionario').addClass("active")

            $('#form').submit((ev) => {
                const funcoesSelecionadas = []
                document.getElementsByName("funcoes[]").forEach(tag => {
                    if (!tag.checked) {
                        return
                    }
                    funcoesSelecionadas.push(Number(tag.value))
                })

                const data = `{"funcoes":${JSON.stringify(funcoesSelecionadas)}}`

                document.getElementById("funcoes-input").value = data
            })
        });
        $(document).ready(function() {
            $("#cpf").mask("999.999.999-99");
        });
    </script>
</body>
