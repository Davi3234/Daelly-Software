<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("location: login.php");
}

require_once "../control/ControlMaquinaCosturaMapa.php";
require_once "../model/DaoMaquinaCosturaMapa.php";
require_once "../model/MaquinaCosturaMapa.php";

$control = new ControlMaquinaCosturaMapa();

$maquinas = $control->listar();
$maquinasMapa = $control->listarMCMapa();
$maquinasInventario = $control->listarMCInventario();

$data = '{';

$i = 0;
if ($maquinas) foreach ($maquinas as $mc) {
    if ($i > 0) {
        $data .= ',';
    }
    $data .= $mc->codigo . ':{"id":' . $mc->id . ',"codigo":' . $mc->codigo . ',
        "x":' . $mc->x . ',"y":' . $mc->y . ',"posicionado":' . $mc->posicionado . ',
    "id_maquina_costura":' . $mc->id_maquina_costura . '}';
    $i++;
}

$data .= '}';
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Gerenciamento de Conteúdo</title>
    <link rel="stylesheet" href="../css/style-mapa.css">
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
    <link href="/css/datepicker3.css" rel="stylesheet">
    <link href="/css/bootstrap-table.css" rel="stylesheet">
    <script src="/js/jquery-3.1.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-table.js"></script>
    <script src="/js/bootbox.js"></script>
    <script src="/js/lumino.glyphs.js"></script>
    <script src="/js/jquery-maskedinput.min.js"></script>
    <script src="/js/mascaras.js"></script>
</head>

<body>

    <nav id="header-content" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
                            </svg><span class="nome_usuario">Usuário Logado </span><span class="caret"></span>
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
                    <li><a href=""><svg class="glyph stroked home">
                                <use xlink:href="#stroked-home"></use>
                            </svg></a></li>
                    <li class="active">Painel de Gerenciamento</li>
                </ol>
            </div>

            <form action="" method="post">
                <div class="panel-heading">
                    <button id="bt-salvar-maquinas" type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="auto"><svg class="glyph stroked checkmark">
                            <use xlink:href="#stroked-checkmark" />
                        </svg> Gravar</button>
                </div>
                <div id="mapa-content">
                    <div id="mapa-box">
                        <div id="mapa">
                            <div class="listas-maquinas" id="lista-maquinas-mapa" ondrop="dropMapa(event)" ondragover="allowDrop(event)">
                                <?php if ($maquinasMapa) foreach ($maquinasMapa as $mc) { ?>
                                    <div draggable="true" ondragstart="drag(event)" class="maquinas" id="maquina-<?php echo $mc->codigo ?>" style="left: <?php echo $mc->x ?>px; top: <?php echo $mc->y ?>px;"><?php echo $mc->codigo ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div id="inventario">
                        <div class="listas-maquinas" id="lista-maquinas-inventario" ondrop="dropInventario(event)" ondragover="allowDrop(event)">
                            <?php if ($maquinasInventario) foreach ($maquinasInventario as $mc) { ?>
                                <div draggable="true" ondragstart="drag(event)" class="maquinas" id="maquina-<?php echo $mc->codigo ?>"><?php echo $mc->codigo ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="maquina-info-content">
        <strong>Máquina <span id="mc-info-codigo"></span></strong>
        <button>Adicionar a máquina ao inventário</button>
    </div>
    <script src="../js/ControlMapa.js"></script>
    <script>
        ! function($) {
            $(document).on("click", "ul.nav li.parent > a > span.icon", function() {
                $(this).find('em:first').toggleClass("glyphicon-minus")
            })
            $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus")
        }(window.jQuery)

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
        const maquinas = JSON.parse(JSON.stringify(<?php echo $data ?>))

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip()
            $('#carregando').fadeOut()
            $('#conteudo').fadeIn()
        })
    </script>
</body>

</html>