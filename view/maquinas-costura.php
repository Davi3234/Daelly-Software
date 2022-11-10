<?php
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
$control = new ControlMaquinaCostura();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->excluir(addslashes($_POST['id']))) {
        $mensagem = "Máquina de costura excluído com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}

$maquinas = $control->listar();
?>

<html>

<head>
<?php include 'header.php' ?>
</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Daelly Confec��es</a>
                <ul class="user-menu">
                    <li class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <svg class="glyph stroked male-user">
                                <use xlink:href="#stroked-male-user"></use>
                            </svg><span class="nome_usuario">Usu�rio Logado </span><span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="logout.php"><svg class="glyph stroked cancel">
                                        <use xlink:href="#stroked-cancel"></use>
                                    </svg> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


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
                    <li class="active">Máquinas de Costura</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Máquinas de Costura</h1>
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

                                <table data-toggle="table" data-show-refresh="true" data-id-field="1" data-show-toggle="true" data-show-columns="false" data-search="true" data-select-item-name="selecionados[]" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true">Código</th>
                                            <th data-sortable="true">Modelo</th>
                                            <th data-sortable="true">Tipo</th>
                                            <th data-sortable="true">Marca</th>
                                            <th data-sortable="true">Chassi</th>
                                            <th data-sortable="true">Aquisição</th>
                                            <th data-sortable="true">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($maquinas) foreach ($maquinas as $t) { ?>
                                            <tr>
                                                <td><?php echo $t->codigo ?></td>
                                                <td><?php echo $t->modelo ?></td>
                                                <td><?php if ($t->tipo) {
                                                        echo $t->tipo;
                                                    } else {
                                                        echo "Nenhum";
                                                    } ?></td>
                                                <td><?php echo $t->marca ?></td>
                                                <td><?php echo $t->chassi ?></td>
                                                <td><?php echo $t->aquisicao ?></td>
                                                <td>
                                                    <a href="#" class="editar" rel="<?php echo $t->id ?>">Editar</a>&nbsp;&nbsp;&nbsp;
                                                    <a href="#" class="excluir" rel="<?php echo $t->id ?>">Excluir</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        ! function($) {
            $(document).on("click", "ul.nav li.parent > a > span.icon", function() {
                $(this).find('em:first').toggleClass("glyphicon-minus");
            });
            $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
        }(window.jQuery);

        $(window).on('resize', function() {
            if ($(window).width() > 768)
                $('#sidebar-collapse').collapse('show')
        })
        $(window).on('resize', function() {
            if ($(window).width() <= 767)
                $('#sidebar-collapse').collapse('hide')
        })
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#carregando').fadeOut();
            $('#conteudo').fadeIn();

            $(".editar").click(function() {
                id = $(this).attr("rel");
                $(location).attr("href", "editar-maquina-costura.php?id=" + id);
            });

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