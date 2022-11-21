<?php
require_once '../model/Grupo.php';
require_once '../model/DaoGrupo.php';
require_once '../control/ControlGrupo.php';
require_once '../model/Funcionario.php';
require_once '../model/DaoFuncionario.php';
require_once '../control/ControlFuncionario.php';
require_once '../model/FuncionarioFuncao.php';
require_once '../model/DaoFuncionarioFuncao.php';
require_once '../control/ControlFuncionarioFuncao.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlGrupo();
$controlFunci = new ControlFuncionario();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($controlFunci->desvincularGrupo(addslashes($_POST["id"]))) {
        if ($control->excluir(addslashes($_POST['id']))) {
            $mensagem = "Grupo excluído com sucesso";
            unset($_POST);
        } else {
            $erros = "";
            foreach ($control->getErros() as $e) {
                $erros = $erros . $e . "<br />";
            }
        }
    } else {
        $erros = "";
        foreach ($controlFunci->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$grupos = $control->listar();
?>

<html>

<head>
    <?php include "header.php" ?>
    <title>Lista de Grupos - Daelly Conffecções</title>
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
                    <h2>Grupos</h2>
                </div>

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

                        <div class="line-division"></div>

                        <div class="actions-form">
                            <a href="cadastro-grupo.php" type="submit" class="bt-action form primary icon-content rigth">Novo<span class="material-symbols-outlined">library_add</span></a>
                        </div>

                        <div class="line-division"></div>

                        <div class="table-content">
                            <div class="fill-inputs">
                                  <div class="input-box input-position-left">
                                    <input type="text" name="filter-table" id="filter-table" autocomplete="off" />
                                    <label for="filter-table">Busca</label>
                                    <i></i>
                                </div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="table-results">
                                    <?php if ($grupos) foreach ($grupos as $g) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $g->numero ?>
                                            </td>
                                            <td>
                                                <div class="actions-form table">
                                                    <a href="editar-grupo.php?id=<?php echo $g->id ?>" class="editar bt-action table bt-edit tooltip-content"><span class="material-symbols-outlined">edit_square</span><span class="tooltip">Editar grupo</span></a>
                                                    <button rel="<?php echo $g->id ?>" class="excluir bt-action table bt-remove tooltip-content"><span class="material-symbols-outlined">delete</span><span class="tooltip">Excluir grupo</span></button>
                                                    <a href="funcionarios-por-grupo.php?id=<?php echo $g->id ?>" class="bt-action table bt-list tooltip-content"><span class="material-symbols-outlined">group</span><span class="tooltip">Funcionários deste grupo</span></a>
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
            $('#i-grupo').addClass("active")

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