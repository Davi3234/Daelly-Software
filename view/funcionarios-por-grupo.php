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
$controlGrupo = new ControlGrupo();

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

$grupo = $controlGrupo->selecionar(addslashes($_GET["id"]));
$funcionarios = $control->listarByGrupo($grupo->id);
?>

<html>

<head>
    <?php include "header.php" ?>
    <title>Lista de Funcionários - Daelly Conffecções </title>
</head>

<body>
    <header id="header">
        <?php include "cabecalho.php" ?>
    </header>

    <main>
        <div id="barra-lateral">
            <?php include "barra-lateral.php" ?>
        </div>

<<<<<<< HEAD
    <?php include 'nome.php' ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div id="carregando">
            Carregando...
        </div>
        <div id="conteudo">

            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="index.php"><svg class="glyph stroked home">
                                <use xlink:href="#stroked-home"></use>
                            </svg></a></li>
                    <li class="active">Funcionários</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Funcionários do grupo <?php echo $grupo->numero; ?></h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <form action="" method="POST" id="form">
                                <input type="hidden" value="" name="id" id="id" />
                                <input type="hidden" value="" name="acao" id="acao" />

                                <?php if (isset($mensagem)) { ?>
                                    <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">X</a>
                                        <?php echo $mensagem; ?>
                                    </div>
                                <?php } ?>

                                <?php if (isset($erros)) { ?>
                                    <div class="alert alert-danger">
                                        <?php echo $erros; ?>
                                    </div>
                                <?php } ?>

                                <div class="table-content">
                                    <table data-toggle="table" data-show-refresh="true" data-id-field="1" data-show-toggle="true" data-show-columns="false" data-search="true" data-select-item-name="selecionados[]" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                                        <thead>
                                            <tr>
                                                <th data-sortable="true">Nome</th>
                                                <th data-sortable="true">CPF</th>
                                                <th data-sortable="true">Entrada</th>
                                                <th data-sortable="true">Saída</th>
                                                <th data-sortable="true">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($funcionarios) foreach ($funcionarios as $f) { ?>
                                                <tr>
                                                    <td><?php echo $f->nome ?></td>
                                                    <td><?php echo $f->cpf ?></td>
                                                    <td><?php echo $f->entrada ?></td>
                                                    <td><?php echo $f->saida ?></td>
                                                    <td>
                                                        <a href="#" class="editar" rel="<?php echo $f->id ?>">Editar</a>&nbsp;&nbsp;&nbsp;
                                                        <a href="#" class="excluir" rel="<?php echo $f->id ?>">Excluir</a>
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
            </div>

=======
        <div id="painel-comando">
            <div id="carregando">
                Carregando...
            </div>

            <div id="conteudo">
                <div class="conteudo-header">
                    <h2>Funcionários do grupo <?php echo $grupo->numero ?><h2>
                </div>
                <div class="line-division"></div>

                <div class="conteudo-main">
                    <form action="" method="POST" id="form">
                        <input type="hidden" value="" name="id" id="id" />
                        <input type="hidden" value="" name="acao" id="acao" />

                        <?php if (isset($mensagem)) { ?>
                            <div class="alert alert-success">
                                <?php echo $mensagem; ?>
                                <div class="close-alert">X</div>
                            </div>
                        <?php } ?>

                        <?php if (isset($erros)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $erros; ?>
                                <div class="close-alert">X</div>
                            </div>
                        <?php } ?>

                        <div class="table-content">
<table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Entrada</th>
                                    <th>Saída</th>
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
                                            <div class="actions-form table">
                                                <a href="editar-funcionario.php?id=<?php echo $f->id ?>" class="editar bt-action table bt-edit"><span class="material-symbols-outlined">edit_square</span></a>
                                                <a href="#" class="excluir bt-action table bt-remove" rel="<?php echo $f->id ?>"><span class="material-symbols-outlined">delete</span></a>
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
>>>>>>> views
        </div>
    </main>


    <script>
        $(document).ready(function() {
            $('#i-funcionario').addClass("active")
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