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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->excluir(addslashes($_POST['id']))) {
        $mensagem = "Funcion�rio exclu�do com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}

$funcionarios = $control->listar();
?>

<html>

<head>
    <?php include "head.php" ?>
    <title>Lista de Funcionários - Daelly Conffecções</title>
</head>

<body>
    <header id="header">
        <?php include "cabecalho.php" ?>
    </header>
<<<<<<< HEAD

    <main>
        <div id="barra-lateral">
            <?php include "barra-lateral.php" ?>
        </div>

        <div id="painel-comando">
            <div id="carregando">
                Carregando...
            </div>

            <div id="conteudo">

            </div>
        </div>
=======

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
                    <h2>Funcionários</h2>
                </div>
                <div class="line-division"></div>

                <div class="conteudo-main">
                    <form action="" method="POST" id="form">
                        <input type="hidden" value="" name="id" id="id" />
                        <input type="hidden" value="" name="acao" id="acao" />

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

                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Entrada</th>
                                    <th>Saída</th>
                                    <th>Grupo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($funcionarios) foreach ($funcionarios as $f) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $f->nome ?>
                                        </td>
                                        <td>
                                            <?php echo $f->cpf ?>
                                        </td>
                                        <td>
                                            <?php echo $f->entrada ?>
                                        </td>
                                        <td>
                                            <?php echo $f->saida ? $f->saida : "----/--/--" ?>
                                        </td>
                                        <td>
                                            <?php echo $f->grupo ? $f->grupo : "Nenhum" ?>
                                        </td>
                                        <td>
                                            <div class="actions-form">
                                                <a href="editar-funcionario.php?id=<?php echo $f->id ?>" class="editar bt-action bt-edit"><span class="material-symbols-outlined">edit_square</span></a>
                                                <a href="#" class="excluir bt-action bt-remove"><span class="material-symbols-outlined">delete</span></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
>>>>>>> styles-page
    </main>

    <script>
        $('#i-funcionario').addClass("active")
        $(document).ready(function() {
            $('#carregando').fadeOut();
            $('#conteudo').fadeIn();

            $(".excluir").click(function() {
                if (confirm("Deseja realmente excluir o registro?")) {
                    id = $(this).attr("rel");
                    $("#id").val(id);
                    $("#form").submit();
                }
            });

        });
    </script>

</body>

</html>