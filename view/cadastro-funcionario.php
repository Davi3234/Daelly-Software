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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $funcoesSelecionadas = json_decode($_POST["funcoes-selecionadas"])->funcoes;

    if ($control->inserir($_POST['cpf'], $_POST['nome'], $_POST['entrada'], $_POST['saida'], $_POST['id_grupo'])) {
        $mensagem = "Funcion�rio inserido com sucesso";
        $control->vincularFuncoes($control->selecionarByCpf($_POST["cpf"])->id, $funcoesSelecionadas);
        unset($_POST);
    }
    if (count($control->getErros()) > 0) {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$listaGru = $controlGru->listar();
$listaFun = $controlFun->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "head.php" ?>
    <title>Cadastro de Funcionário - Daelly Conffecções</title>
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
                    <h2>Cadastro de Funcionário</h2>
                </div>

                <div class="line-division"></div>

                <div class="conteudo-main">

                    <form action="" method="post" id="form"></form>
                    <input hidden type="text" name="funcoes-selecionadas" id="funcoes-input" value='{"funcoes":[]}'>

                    <div class="actions-form">
                        <button type="submit" id="gravar" class="bt-action form primary">Gravar</button>
                        <button type="button" class="bt-action form primary voltar">Voltar</button>
                    </div>

                    <div class="line-division"></div>

                    <div class="fill-inputs">
                        <div class="input-box input-position-left">
                            <input type="text" name="nome" id="nome" required="required" autofocus="TRUE">
                            <label for="nome">Nome</label>
                            <i></i>
                        </div>
                        <div class="input-box input-position-right">
                            <input type="text" name="entrada" id="entrada" required="required">
                            <label for="entrada">Entrada</label>
                            <i></i>
                        </div>
                        <div class="input-box input-position-left">
                            <input type="text" name="cpf" id="cpf" required="required">
                            <label for="cpf">CPF</label>
                            <i></i>
                        </div>
                        <div class="input-box input-position-right">
                            <input type="text" name="saida" id="saida" required="required">
                            <label for="saida">Saída</label>
                            <i></i>
                        </div>
                    </div>
                </div>


            </div>
            </form>
        </div>
        </div>
        </div>
    </main>

    <script>
        $('#i-funcionario').addClass("active")
        $(document).ready(function() {
            $('#carregando').fadeOut();
            $('#conteudo').fadeIn();

            $(".voltar").click(function() {
                $(location).attr("href", "funcionarios.php");
            });

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

</html>