<?php
require_once '../model/Grupo.php';
require_once '../model/DaoGrupo.php';
require_once '../control/ControlGrupo.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlGrupo();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->editar($_POST['numero'], addslashes($_GET['id']))) {
        $mensagem = "Grupo editado com sucesso";
        unset($_POST);
    }
    if (count($control->getErros()) > 0) {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$grupo = $control->selecionar(addslashes($_GET['id']));
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "header.php" ?>
    <title>Editar Grupo - Daelly Conffecções</title>
</head>

<body>
    <header>
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

            <div class="conteudo">
                <div class="conteudo-header">
                    <h2>Editar Grupo</h2>
                </div>

                <?php if (isset($mensagem)) { ?>
                    <div class="alert alert-success">
                        <?php echo $mensagem; ?>
                        <div class="close-alert material-symbols-outlined">close</div>
                    </div>
                <?php } ?>

                <?php if (isset($erros)) { ?>
                    <div class="alert alert-danger">
                        <?php echo $erros; ?>
                        <div class="close-alert material-symbols-outlined">close</div>
                    </div>
                <?php } ?>

                <div class="line-division"></div>

                <div class="conteudo-main">
                    <form action="" method="post" id="form">
                        <div class="actions-form">
                            <button type="submit" id="gravar" class="bt-action form primary icon-content rigth">Gravar<span class="material-symbols-outlined">done</span></button>
                            <a href="grupos.php" class="bt-action form primary icon-content rigth">Grupos<span class="material-symbols-outlined">list</span></a>
                            <button type="button" class="bt-action form primary voltar icon-content rigth">Voltar<span class="material-symbols-outlined">redo</span></button>
                        </div>

                        <div class="line-division"></div>

                        <div class="fill-inputs">
                            <div class="input-box input-position-left">
                                <input type="text" name="numero" id="numero" value="<?php echo $grupo->numero ?>" required="required" autofocus="TRUE">
                                <label for="numero">Número*</label>
                                <i></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#i-grupo').addClass("active")
            $('#carregando').fadeOut();
            $('.conteudo').fadeIn();

            $(".voltar").click(function() {
                $(location).attr("href", "grupos.php");
            });
        });
    </script>
</body>

</html>