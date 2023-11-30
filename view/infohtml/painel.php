<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("location: login.php");
}

require_once "../../control/ControlMaquinaCosturaMapa.php";
require_once "../../model/DaoMaquinaCosturaMapa.php";
require_once "../../model/MaquinaCosturaMapa.php";
require_once "../../control/ControlMapa.php";
require_once "../../model/DaoMapa.php";

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
    </style>
</head>

<body>
    <header>
        <?php include "cabecalho.php" ?>
    </header>

    <main>
        <div id="barra-lateral">
            <?php include "barra-lateral.php" ?>
        </div>

        <div id="painel-comando" class="pc-mapa">
            <div class="carregando">
                Carregando...
            </div>

            <div class="conteudo pc-header">
                <h2>Mapeamento das máquinas de costura</h2>

                <?php if (isset($mensagem)) { ?>
                    <div class="alert alert-success">
                        <?php echo $mensagem; ?>
                        <div class="close-alert material-symbols-outlined">close</div>
                    </div>
                <?php } ?>
                <?php if (isset($erro)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $erro; ?>
                        <div class="close-alert material-symbols-outlined">close</div>
                    </div>
                <?php } ?>

                <div class="line-division"></div>

                <div class="actions-form">
                    <button id="bt-salvar-maquinas" type="submit" class="bt-action form primary toggle icon-content rigth">Gravar<span class="material-symbols-outlined">done</span></button>
                    <button id="bt-resetar-maquinas" type="button" class="bt-action form primary toggle icon-content rigth">Resetar<span class="material-symbols-outlined">restart_alt</span></button>
                    <button id="bt-guardar-maquinas" type="button" class="bt-action form primary toggle icon-content rigth">Guardar máquinas no inventário<span class="material-symbols-outlined">dynamic_feed</span></button>
                </div>
            </div>

            <div class="conteudo pc-conteudo">
                <form action="" method="post" id="editar-maquinas-mapa">
                    <input id="maquinas-input" name="maquinas" type="text" hidden value='{"maquinas":[]}'>

                    <div id="mapa-content">
                        <div id="mapa-box">
                            <div id="mapa" style="width: <?php echo $mapa->largura_mapa ?>px; height: <?php echo $mapa->altura_mapa ?>px;">
                                <div id="lista-maquinas-mapa" class="listas-maquinas" ondrop="dropMapa(event)" ondragover="allowDrop(event)">
                                    <img src="../assets/imgs/Mapa.png" alt="Mapa" style="position: absolute;">
                                    <?php if ($maquinasMapa) foreach ($maquinasMapa as $mc) { ?>
                                        <div draggable="true" ondragstart="drag(event)" class="maquinas" id="maquina-<?php echo $mc->codigo ?>" style="left: <?php echo $mc->x ?>px; top: <?php echo $mc->y ?>px; width: <?php echo $mapa->largura_mc ?>px; height: <?php echo $mapa->altura_mc ?>px;">
                                            <div class="mc-content">
                                                <img src="../assets/imgs/icons/mc-mapa/mc-medium.png" alt="">
                                                <p><?php echo $mc->codigo ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div id="inventario">
                            <div id="lista-maquinas-inventario" style="height: calc(<?php echo $mapa->altura_mc ?>px + 3rem);" class="listas-maquinas" ondrop="dropInventario(event)" ondragover="allowDrop(event)">
                                <?php if ($maquinasInventario) foreach ($maquinasInventario as $mc) { ?>
                                    <div style="width: <?php echo $mapa->largura_mc ?>px; height: <?php echo $mapa->altura_mc ?>px;" draggable="true" ondragstart="drag(event)" class="maquinas" id="maquina-<?php echo $mc->codigo ?>">
                                        <div class="mc-content">
                                            <img src="../assets/imgs/icons/mc-mapa/mc-medium.png" alt="">
                                            <p><?php echo $mc->codigo ?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="maquina-info-content">
                <input type="hidden" value="" name="id_maquina_costura" id="id_maquina_costura">
                <input type="hidden" value="" name="id_maquina_costura_mapa" id="id_maquina_costura_mapa">
                <div class="close-info material-symbols-outlined">close</div>
                <div class="mc-info">
                    <div class="info-left">
                        <strong>Máquina <span id="mc-info-codigo">0</span></strong>
                        <p>Tipo: <span id="mc-info-tipo">Nenhum</p>
                        <p>Aquisição: <span id="mc-info-aquisicao">Nenhum</p>
                    </div>
                    <div class="info-right">
                        <p>Modelo: <span id="mc-info-modelo">Nenhum</p>
                        <p>Marca: <span id="mc-info-marca">Nenhum</p>
                        <p>Chassi: <span id="mc-info-chassi">Nenhum</p>
                    </div>
                </div>
                <div class="actions-form">
                    <button type="button" id="bt-guardar-maquina" class="bt-action form primary icon-content rigth">Adicionar a máquina ao inventário<span class="material-symbols-outlined">dynamic_feed</span></button>
                    <button id="bt-cadastrar-manutencao" type="button" class="bt-action form primary icon-content rigth">Manutenções<span class="material-symbols-outlined">build</span></button>
                    <button id="bt-editar-maquina" type="button" class="bt-action form primary icon-content rigth">Editar máquina<span class="material-symbols-outlined">edit_square</span></button>
                </div>
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
            $("#i-menu").click(() => {
                $("#barra-lateral").toggleClass("active")
            })
            $('.carregando').fadeOut()
            $('.conteudo').fadeIn()
            $('#bt-guardar-maquinas').click(guardarMaquinas)
            $('#bt-guardar-maquina').click(guardarMaquina)
            $('#bt-salvar-maquinas').click(gravarMaquinasAlteradas)
            $('#bt-resetar-maquinas').click(resetarMaquinasAlteradas)
            $('#editar-maquinas-mapa').submit((ev) => {
                if (maquinasAlteradas.length <= 0) {
                    ev.preventDefault()
                    return
                }

                editarMaquinasAlteradas()
            })
            $('#bt-editar-maquina').click((ev) => {
                const id = Number(document.getElementById("id_maquina_costura").value)
                $(location).attr("href", "editar-maquina-costura.php?id=" + id);
            })
            $('#bt-cadastrar-manutencao').click((ev) => {
                const id = Number(document.getElementById("id_maquina_costura").value)
                $(location).attr("href", "manutencoes-por-maquina.php?id=" + id);
            })

            $(".item-children.header").click(({
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
            })

            $("#active-side-bar").click(menuToggle)
            $(".close-alert").click(closeAlert)
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
            document.querySelector(".alert") && document.querySelector(".alert").remove()
        }

        function menuToggle() {
            document.querySelector("#barra-lateral").classList.toggle("active")
        }
    </script>
</body>

</html>