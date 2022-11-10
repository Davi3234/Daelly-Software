<?php
require_once '../model/MaquinaCostura.php';
require_once '../model/DaoMaquinaCostura.php';
require_once '../control/ControlMaquinaCostura.php';
require_once '../model/MaquinaCosturaMapa.php';
require_once '../model/DaoMaquinaCosturaMapa.php';
require_once '../control/ControlMaquinaCosturaMapa.php';
require_once '../model/Tipo.php';
require_once '../model/DaoTipo.php';
require_once '../control/ControlTipo.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlMaquinaCostura();
$controlTipo = new ControlTipo();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->editar(addslashes($_GET["id"]), $_POST["codigo"], $_POST["modelo"], $_POST["marca"], $_POST["chassi"], $_POST["aquisicao"], $_POST["tipo"])) {
        $mensagem = "Máquina de costura editada com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$tipos = $controlTipo->listar();
$maquina = $control->selecionar(addslashes($_GET["id"]));
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
                        <form action="" method="POST" id="form" name="form">
                            <div class="panel-heading">
                                <button type="submit" class="btn btn-primary" data-toggle="tooltip" title="Gravar o registro" data-placement="auto"><svg class="glyph stroked checkmark">
                                        <use xlink:href="#stroked-checkmark" />
                                    </svg> Gravar</button>
                                <button type="button" class="btn btn-primary voltar" data-toggle="tooltip" title="Voltar para a listagem" data-placement="auto"><svg class="glyph stroked arrow left">
                                        <use xlink:href="#stroked-arrow-left" />
                                    </svg> Voltar</button>
                            </div>
                            <div class="panel-body">

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

                                <div class="campo_esquerda">
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['chassi'])) ? $_POST['chassi'] : $maquina->chassi ?>" name="chassi" id="chassi" placeholder="Informe o chassi" required="required" data-toggle="tooltip" title="Informe o chassi" data-placement="auto" />
                                </div>
                                <div class="campo_direita">
                                    <input type="number" min="1" class="form-control" value="<?php echo (isset($_POST['codigo'])) ? $_POST['codigo'] : $maquina->codigo ?>" name="codigo" id="codigo" placeholder="Informe o codigo" required="required" data-toggle="tooltip" title="Informe o código" data-placement="auto" />
                                </div>
                                <div class="campo_esquerda">
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['modelo'])) ? $_POST['modelo'] : $maquina->modelo ?>" name="modelo" id="modelo" placeholder="Informe o modelo" required="required" data-toggle="tooltip" title="Informe o modelo" data-placement="auto" />
                                </div>
                                <div class="campo_direita">
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['marca'])) ? $_POST['marca'] : $maquina->marca ?>" name="marca" id="marca" placeholder="Informe o marca" required="required" data-toggle="tooltip" title="Informe a marca" data-placement="auto" />
                                </div>
                                <div class="campo_esquerda">
                                    <select class="form-control" id="tipo" name="tipo" required="required" placeholder="Informe o tipo" data-toggle="tooltip" title="Informe o tipo" data-placement="auto">
                                        <option value="0">Selecione</option>
                                        <?php foreach ($tipos as $t) { ?>
                                            <option <?php if ($maquina->id_tipo == $t->id) { ?> selected <?php } ?> value="<?php echo $t->id ?>"><?php echo $t->nome ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="campo_direita">
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['aquisicao'])) ? $_POST['aquisicao'] : $maquina->aquisicao ?>" name="aquisicao" id="aquisicao" placeholder="Informe o aquisicao" required="required" data-toggle="tooltip" title="Informe a aquisição" data-placement="auto" />
                                </div>
                            </div>
                    </div>
                </div>
                </form>
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

            $(".voltar").click(function() {
                $(location).attr("href", "tipos.php");
            });

        });
    </script>

</body>

</html>