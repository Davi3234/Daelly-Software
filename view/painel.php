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

        <div id="painel-comando">
            <div id="carregando">
                Carregando...
            </div>

            <div id="conteudo">
<<<<<<< HEAD
                
=======

>>>>>>> styles-page
            </div>
        </div>
    </main>

    <!-- <script src="../js/ControlMapa.js"></script> -->
    <script>
        $('#i-inicio').addClass("active")
        const {
            maquinas
        } = JSON.parse(JSON.stringify(<?php echo $data ?>))
        const maquinasAlteradas = []

        $(document).ready(function() {
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
</body>

</html>