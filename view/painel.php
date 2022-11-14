<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("location: login.php");
}

require_once "../control/ControlMaquinaCosturaMapa.php";
require_once "../model/DaoMaquinaCosturaMapa.php";
require_once "../model/MaquinaCosturaMapa.php";
require_once "../control/ControlMapa.php";
require_once "../model/DaoMapa.php";

$control = new ControlMaquinaCosturaMapa();
$controlMapa = new ControlMapa();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maquinasAlteradas = json_decode($_POST["maquinas"])->maquinas;

    foreach ($maquinasAlteradas as $mc) {
        $control->editar($mc->id, $mc->posicionado, $mc->x, $mc->y);
    }
}

$maquinas = $control->listar();
$maquinasMapa = $control->listarMCMapa();
$maquinasInventario = $control->listarMCInventario();
$mapa = $controlMapa->selecionar();

$data = '{"maquinas":[';
$i = 0;
if ($maquinas) foreach ($maquinas as $mc) {
    if ($i > 0) {
        $data .= ',';
    }
    $data .= json_encode($mc);
    $i++;
}
$data .= ']}';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "head.php" ?>
    <title>Painel - Daelly Conffecções</title>
</head>

<body>
    <header id="header">
        <?php include "cabecalho.php" ?>
    </header>

    <main>
        <div id="barra-lateral">
            <?php include "barra-lateral.php" ?>
        </div>

        <div id="painel-comando" class="pc-mapa" style="padding: 2rem;">
            <div id="carregando">
                Carregando...
            </div>

            <div id="conteudo" style="padding: 0;">
                <form action="" method="post" id="editar-maquinas-mapa" style="width: 100%; height: 100%;">
                    <input id="maquinas-input" name="maquinas" type="text" hidden value='{"maquinas":[]}'>
                    <div id="mapa-content">
                        <div id="mapa-box">
                            <div id="mapa" style="width: <?php echo $mapa->largura_mapa ?>px; height: <?php echo $mapa->altura_mapa ?>px;">
                                <div class="listas-maquinas" id="lista-maquinas-mapa" ondrop="dropMapa(event)" ondragover="allowDrop(event)">
                                    <?php if ($maquinasMapa) foreach ($maquinasMapa as $mc) { ?>
                                        <div draggable="true" ondragstart="drag(event)" class="maquinas" id="maquina-<?php echo $mc->codigo ?>" style="left: <?php echo $mc->x ?>px; top: <?php echo $mc->y ?>px; width: <?php echo $mapa->largura_mc ?>px; height: <?php echo $mapa->altura_mc ?>px;"><?php echo $mc->codigo ?></div>
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
                <div id="maquina-info-content" style="display: none !important;">
                    <strong>Máquina <span id="mc-info-codigo"></span></strong>
                    <button>Adicionar a máquina ao inventário</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        const {
            maquinas
        } = JSON.parse(JSON.stringify(<?php echo $data ?>))
        const maquinasAlteradas = []

        $(document).ready(function() {
            $('#i-inicio').addClass("active")
            $('#carregando').fadeOut()
            $('#conteudo').fadeIn()
            $('#editar-maquinas-mapa').submit((ev) => {
                if (maquinasAlteradas.length <= 0) {
                    ev.preventDefault()
                    return
                }

                editarMaquinasAlteradas()
            })
        })
        
        function editarMaquinasAlteradas() {
            const tag = document.getElementById("maquinas-input")
            
            let data = `{"maquinas":${JSON.stringify(maquinasAlteradas)}}`
            
            tag.value = data
        }
        </script>
    <!-- <script src="../js/ControlMapa.js"></script> -->
</body>

</html>
<!-- <div class="panel-heading">
                        <button id="bt-salvar-maquinas" type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="auto"><svg class="glyph stroked checkmark">
                                <use xlink:href="#stroked-checkmark" />
                            </svg> Gravar</button>
                        <button id="bt-resetar-maquinas" onclick="resetarMaquinasAlteradas()" type="button" class="btn btn-primary resetar" data-toggle="tooltip" data-placement="auto"><svg class="glyph stroked arrow left">
                                <use xlink:href="#stroked-arrow-left" />
                            </svg> Resetar</button>
                    </div> -->