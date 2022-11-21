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
$controlTipo = new ControlTipo();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->desvincularTipo(addslashes($_POST['id']))) {
        $mensagem = "Função desvinculado do tipo com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}

$tipo = $controlTipo->selecionar(addslashes($_GET["id"]));
$funcoes = $control->listarByTipo($tipo->id);
?>

<html>

<head>
    <?php include "header.php" ?>
    <title>Lista de Funções - Daelly Conffecções</title>
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
                    <h2>Funções do tipo <?php echo $tipo->nome ?></h2>
                </div>
                <div class="line-division"></div>

                <div class="actions-form">
                    <a href="cadastro-funcao.php?tipo=<?php echo $tipo->id ?>" class="bt-action form primary icon-content rigth">Novo<span class="material-symbols-outlined">library_add</span></a>
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
                                    <input type="text" name="filter-table" id="filter-table" autocomplete="off" />
                                    <label for="filter-table">Busca</label>
                                    <i></i>
                                </div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="table-results">
                                    <?php if ($funcoes) foreach ($funcoes as $f) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $f->nome ?>
                                            </td>
                                            <td>
                                                <div class="actions-form table">
                                                    <a href="editar-funcao.php?id=<?php echo $f->id ?>" class="editar bt-action table bt-edit tooltip-content"><span class="material-symbols-outlined">edit_square</span><span class="tooltip">Editar Função</span></a>
                                                    <button rel="<?php echo $f->id ?>" class="excluir bt-action table bt-remove tooltip-content"><span class="material-symbols-outlined">do_not_disturb_on</span><span class="tooltip">Desvincular deste tipo</span></button>
                                                    <a href="funcionarios-por-funcao.php?id=<?php echo $f->id ?>" class="bt-action table bt-list tooltip-content"><span class="material-symbols-outlined">group</span><span class="tooltip">Funcionários desta função</span></a>
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
            $('#i-tipo').addClass("active")

            $(".excluir").click(function() {
                if (confirm("Deseja realmente desvincular essa função do tipo?")) {
                    id = $(this).attr("rel");
                    $("#id").val(id);
                    $("#form").submit();
                }
            });

        });
    </script>

</body>

</html>