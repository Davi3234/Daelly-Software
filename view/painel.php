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

$data = '{"dimensao":{"maquina":{"altura":' . $mapa->altura_mc . ',"largura":' . $mapa->largura_mc . '},"mapa":{"altura":' . $mapa->altura_mapa . ',"largura":' . $mapa->largura_mapa . '}},"maquinas":[';
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
    <?php include "header.php" ?>
    <title>Painel - Daelly Confecções</title>
    <style>
        body {
            height: 100vh;
        }

        .conteudo-header {
            display: none;
        }
    </style>
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
                            <div class="close-alert material-symbols-outlined">close</div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($erro)) { ?>
                    <div class="alert-content">
                        <div class="line-division"></div>

                        <div class="alert alert-danger">
                            <?php echo $erro; ?>
                            <div class="close-alert material-symbols-outlined">close</div>
                        </div>
                    </div>
                <?php } ?>

                <div class="line-division"></div>

                <div class="actions-form">
                    <button id="bt-salvar-maquinas" type="submit" class="bt-action form primary" onclick="gravarMaquinasAlteradas()">Gravar</button>
                    <button id="bt-resetar-maquinas" type="button" class="bt-action form primary voltar" onclick="resetarMaquinasAlteradas()">Resetar</button>
                    <button id="bt-guardar-maquinas" type="button" class="bt-action form primary valid" onclick="guardarMaquinas()">Guardar máquinas no inventário</button>
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
                                        <div draggable="true" ondrop="return false" ondragstart="drag(event)" class="maquinas" id="maquina-<?php echo $mc->codigo ?>" style="left: <?php echo $mc->x ?>px; top: <?php echo $mc->y ?>px; width: <?php echo $mapa->largura_mc ?>px; height: <?php echo $mapa->altura_mc ?>px;"><?php echo $mc->codigo ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div id="maquina-info-content" style="bottom: calc(<?php echo $mapa->altura_mc ?>px + 4rem);">
                                <div class="close-info material-symbols-outlined">close</div>
                                <strong>Máquina <span id="mc-info-codigo">0</span></strong>
                                <p>Tipo: <span id="mc-info-tipo">Nenhum</p>
                                <button type="button" id="bt-guardar-maquina" class="bt-action form primary">Adicionar a máquina ao inventário</button>
                            </div>
                        </div>
                        <div id="inventario">
                            <div id="lista-maquinas-inventario" style="height: calc(<?php echo $mapa->altura_mc ?>px + 2rem);" class="listas-maquinas" ondrop="dropInventario(event)" ondragover="allowDrop(event)">
                                <?php if ($maquinasInventario) foreach ($maquinasInventario as $mc) { ?>
                                    <div style="width: <?php echo $mapa->largura_mc ?>px; height: <?php echo $mapa->altura_mc ?>px;" draggable="true" ondragstart="drag(event)" class="maquinas" id="maquina-<?php echo $mc->codigo ?>"><?php echo $mc->codigo ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="/js/jquery-3.1.0.min.js"></script>
    <script src="/js/jquery-maskedinput.min.js"></script>
    <script src="/js/script.js"></script>
    <script src="../js/ControlMapa.js"></script>
    <script>
        const {
            dimensao,
            maquinas
        } = JSON.parse(JSON.stringify(<?php echo $data ?>))
        const maquinasAlteradas = []

        $(document).ready(function() {
            $('#i-inicio').addClass("active")
            $('#carregando').fadeOut()
            $('#conteudo').fadeIn()
            $('.conteudo-header').fadeIn()
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
                if (!tag.classList.contains("active")) {
                    document.querySelectorAll(".item-children.itens.active").forEach(a => {
                        a.classList.toggle("active", false)
                    })
                }
                tag.classList.toggle("active");
            }))

            document.querySelector("#active-side-bar").addEventListener("click", menuToggle)
            document.querySelector(".close-alert") && document.querySelector(".close-alert").addEventListener("click", closeAlert)
            setTimeout(closeAlert, 1000 * 10)
        })

        function gravarMaquinasAlteradas() {
            $('#editar-maquinas-mapa').submit()
        }

        function editarMaquinasAlteradas() {
            const tag = document.getElementById("maquinas-input")

            let data = `{"maquinas":${JSON.stringify(maquinasAlteradas)}}`

            tag.value = data
        }

        function closeAlert() {
            document.querySelector(".alert-content") && document.querySelector(".alert-content").remove()
        }

        function menuToggle() {
            document.querySelector("#barra-lateral").classList.toggle("active")
        }
    </script>
</body>

</html>