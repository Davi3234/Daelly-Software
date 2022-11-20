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
$controlFuncao = new ControlFuncao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->excluirFuncaoFuncionario(addslashes($_POST['id']), addslashes($_GET["id"]))) {
        $mensagem = "Função desvinculada do funcionário excluído com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}

$funcao = $controlFuncao->selecionar(addslashes($_GET["id"]));
$funcionarios = $control->listarByFuncao($funcao->id);
?>
<!DOCTYPE html>
<html>

<head>
    <?php include "header.php" ?>
    <title>Lista de Funcionários - Daelly Conffecções </title>
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
                    <h2>Funcionários que exercem a função <?php echo $funcao->nome ?><h2>
                </div>
                <div class="line-division"></div>

                <div class="actions-form">
                    <a href="cadastro-funcionario.php?funcao=<?php echo $funcao->id ?>" class="bt-action form primary icon-content rigth">Novo<span class="material-symbols-outlined">library_add</span></a>
                    <button type="submit" class="bt-action form primary icon-content rigth voltar">Voltar<span class="material-symbols-outlined">redo</span></button>
                </div>
                <div class="line-division"></div>

                <div class="conteudo-main">
                    <form action="" method="POST" id="form">
                        <input type="hidden" value="" name="id" id="id" />
                        <input type="hidden" value="" name="acao" id="acao" />

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

                        <div class="table-content">
                            <div class="fill-inputs">
                                <div class="input-box input-position-left">
                                    <input type="text" name="filter-table" id="filter-table" autocomplete="off" placeholder="Digite o seu filtro" />
                                    <label for="filter-table">Filtro</label>
                                    <i></i>
                                </div>
                            </div>
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
                                <tbody id="table-results">
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
                                                <div class="actions-form table">
                                                    <a href="editar-funcionario.php?id=<?php echo $f->id ?>" class="editar bt-action table bt-edit"><span class="material-symbols-outlined">edit_square</span></a>
                                                    <a href="#" class="excluir bt-action table bt-remove" rel="<?php echo $f->id ?>"><span class="material-symbols-outlined">person_remove</span></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>


    <script>
        $(document).ready(function() {
            $('#i-funcao').addClass("active")

            $(".excluir").click(function() {
                if (confirm("Deseja realmente desvincular esse funcionário da função?")) {
                    id = $(this).attr("rel");
                    $("#id").val(id);
                    $("#form").submit();
                }
            });
        });
    </script>

</body>

</html>