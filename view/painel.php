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
        if ($control->editar($mc->id, $mc->posicionado, $mc->x, $mc->y)) {
            $mensagem = "Máquinas de Costura editadas com sucesso";
            unset($_POST);
        } else {
            $erro = "Erro ao editar as máquinas de costura";
        }
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

        <div id="painel-comando" class="pc-mapa">
            <div id="carregando">
                Carregando...
            </div>

            <div class="conteudo-header">
                <h2>Mapeamento das máquinas de costura</h2>

                <?php if (isset($mensagem)) { ?>
                    <div class="alert-content">
                        <div class="line-division"></div>

                        <div class="alert alert-success">
                            <?php echo $mensagem; ?>
                            <div class="close-alert">X</div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($erro)) { ?>
                    <div class="alert-content">
                        <div class="line-division"></div>

                        <div class="alert alert-danger">
                            <?php echo $erro; ?>
                            <div class="close-alert">X</div>
                        </div>
                    </div>
                <?php } ?>

                <div class="line-division"></div>

                <div class="actions-form">
                    <button id="bt-salvar-maquinas" type="submit" id="bt-salvar-maquinas" class="bt-action form primary" onclick="gravarMaquinasAlteradas()">Gravar</button>
                    <button id="bt-resetar-maquinas" type="button" id="bt-resetar-maquinas" class="bt-action form primary voltar" onclick="resetarMaquinasAlteradas()">Resetar</button>
                </div>
            </div>

            <div id="conteudo">
                <form action="" method="post" id="editar-maquinas-mapa">
                    <input id="maquinas-input" name="maquinas" type="text" hidden value='{"maquinas":[]}'>

                    <div id="mapa-content">
                        <div id="mapa-box">
                            <div id="mapa" style="width: <?php echo $mapa->largura_mapa ?>px; height: <?php echo $mapa->altura_mapa ?>px;">
                                <div id="lista-maquinas-mapa" class="listas-maquinas" ondrop="dropMapa(event)" ondragover="allowDrop(event)">
                                    <?php if ($maquinasMapa) foreach ($maquinasMapa as $mc) { ?>
                                        <div draggable="true" ondragstart="drag(event)" class="maquinas" id="maquina-<?php echo $mc->codigo ?>" style="left: <?php echo $mc->x ?>px; top: <?php echo $mc->y ?>px; width: <?php echo $mapa->largura_mc ?>px; height: <?php echo $mapa->altura_mc ?>px;"><?php echo $mc->codigo ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div id="inventario">
                            <div id="lista-maquinas-inventario" class="listas-maquinas" ondrop="dropInventario(event)" ondragover="allowDrop(event)">
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

    <script src="../js/ControlMapa.js"></script>
    <script>
        const {
            maquinas
        } = JSON.parse(JSON.stringify(<?php echo $data ?>))
        const maquinasAlteradas = []

        $(document).ready(function() {
            $('#i-inicio').addClass("active")
            $('#carregando').fadeOut()
            $('#conteudo').fadeIn()
            $('.extra-header').fadeIn()
            $('#editar-maquinas-mapa').submit((ev) => {
                if (maquinasAlteradas.length <= 0) {
                    ev.preventDefault()
                    return
                }

                editarMaquinasAlteradas()
            })

            document.querySelectorAll(".item-children.header").forEach(a => a.addEventListener("click", ({
                target
            }) => {
                if (target.classList.contains("no-expansive")) {
                    return
                }
                const tag = document.querySelector(".item-children.itens#i-expansive-" + (target.id.substr(2)))
                if (!tag) {
                    return
                }
                tag.classList.toggle("active");
            }))

            document.querySelector(".close-alert").addEventListener("click", (ev) => {
        document.querySelector(".alert-content").remove()
    })
    setTimeout(() => {
        document.querySelector(".alert-content") && document.querySelector(".alert-content").remove()
    }, 1000 * 10)
        })

        function gravarMaquinasAlteradas() {
            $('#editar-maquinas-mapa').submit()
        }

        function editarMaquinasAlteradas() {
            const tag = document.getElementById("maquinas-input")

            let data = `{"maquinas":${JSON.stringify(maquinasAlteradas)}}`

            tag.value = data
        }
    </script>
</body>

</html>