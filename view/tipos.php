<?php
require_once '../model/Tipo.php';
require_once '../model/DaoTipo.php';
require_once '../control/ControlTipo.php';
require_once '../model/Funcionario.php';
require_once '../model/DaoFuncionario.php';
require_once '../control/ControlFuncionario.php';
require_once '../model/FuncionarioFuncao.php';
require_once '../model/DaoFuncionarioFuncao.php';
require_once '../control/ControlFuncionarioFuncao.php';
require_once '../model/Funcao.php';
require_once '../model/DaoFuncao.php';
require_once '../control/ControlFuncao.php';
require_once '../model/MaquinaCostura.php';
require_once '../model/DaoMaquinaCostura.php';
require_once '../control/ControlMaquinaCostura.php';
require_once '../model/MaquinaCosturaMapa.php';
require_once '../model/DaoMaquinaCosturaMapa.php';
require_once '../control/ControlMaquinaCosturaMapa.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlTipo();
$controlMC = new ControlMaquinaCostura();
$controlFunca = new ControlFuncao();
$controlFF = new ControlFuncionarioFuncao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$controlMC->isMcByTipo(addslashes($_POST['id'])) > 0) {
        if ($controlFunca->desvincularByTipo(addslashes($_POST['id']))) {
            if ($control->excluir(addslashes($_POST['id']))) {
                $mensagem = "Tipo excluído com sucesso";
                unset($_POST);
            } else {
                $erros = "";
                foreach ($controlFunca->getErros() as $e) {
                    $erros = $erros . $e . "<br />";
                }
            }
        } else {
            $erros = "";
            foreach ($control->getErros() as $e) {
                $erros = $erros . $e . "<br />";
            }
        }
    } else {
        $erros = "Não foi possível excluir esse tipo pois há máquinas de costura vinculadas à ele";
    }
}
$tipos = $control->listar();
?>

<html>

<head>
    <?php include "header.php" ?>
    <title>Lista de Tipos - Daelly Confecções</title>
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
                    <h2>Tipos</h2>
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
                            <a href="cadastro-tipo.php" type="submit" class="bt-action form primary icon-content rigth">Novo<span class="material-symbols-outlined">library_add</span></a>
                        </div>

                        <div class="line-division"></div>

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
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="table-results">
                                    <?php if ($tipos) foreach ($tipos as $t) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $t->nome ?>
                                            </td>
                                            <td>
                                                <div class="actions-form table">
                                                    <a href="editar-tipo.php?id=<?php echo $t->id ?>" class="editar bt-action table bt-edit"><span class="material-symbols-outlined">edit_square</span></a>
                                                    <a href="#" rel="<?php echo $t->id ?>" class="excluir bt-action table bt-remove"><span class="material-symbols-outlined">delete</span></a>
                                                    <a href="maquinas-costura-por-tipo.php?id=<?php echo $t->id ?>" class="bt-action table bt-list"><span class="material-symbols-outlined">tag</span></a>
                                                    <a href="funcoes-por-tipo.php?id=<?php echo $t->id ?>" class="bt-action table bt-list"><span class="material-symbols-outlined">psychology</span></a>
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