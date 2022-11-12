<?php
require_once '../model/Compressor.php';
require_once '../model/DaoCompressor.php';
require_once '../control/ControlCompressor.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlCompressor();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->inserir($_POST['codigo'], $_POST['marca'], $_POST['modelo'])) {
        $mensagem = "Compressor inserido com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
?>

<html>

<head>
    <?php include 'header.php' ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
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
                    <li class="active">Compressor</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Compressor</h1>
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
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['codigo'])) ? $_POST['codigo'] : "" ?>" name="codigo" id="codigo" placeholder="Informe o código" required="required" data-toggle="tooltip" title="Informe o código" data-placement="auto" />
                                </div>
                                <div class="campo_direita">
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['marca'])) ? $_POST['marca'] : "" ?>" name="marca" id="marca" placeholder="Informe a marca" required="required" data-toggle="tooltip" title="Informe a marca" data-placement="auto" />
                                </div>
                                <div class="campo_esquerda">
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['modelo'])) ? $_POST['modelo'] : "" ?>" name="modelo" id="modelo" placeholder="Informe o modelo" required="required" data-toggle="tooltip" title="Informe o modelo" data-placement="auto" />
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
            $(".parent#menu-item-compressor").addClass("active");
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
                $(location).attr("href", "compressores.php");
            });

        });
    </script>

</body>

</html>