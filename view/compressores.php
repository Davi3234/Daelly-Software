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
    if ($control->excluir(addslashes($_POST['id']))) {
        $mensagem = "Compressor exclu�do com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$compressores = $control->listar();
?>

<html>

<head>
    <?php include "head.php" ?>
    <title>Lista de Compressores - Daelly Confe��es</title>
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
                <div class="conteudo-header">
                    <h2>Compressores</h2>
                </div>
                <div class="line-division"></div>

                <div class="conteudo-main">
                    <form action="" method="POST" id="form">
                        <input type="hidden" value="" name="id" id="id" />
                        <input type="hidden" value="" name="acao" id="acao" />

                        <?php if (isset($mensagem)) { ?>
                            <div class="alert alert-success">
                                <?php echo $mensagem; ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($erros)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $erros; ?>
                            </div>
                        <?php } ?>

                        <table>
                            <thead>
                                <tr>
                                    <th>C�digo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>A��es</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($compressores) foreach ($compressores as $c) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $c->codigo ?>
                                        </td>
                                        <td>
                                            <?php echo $c->marca ?>
                                        </td>
                                        <td>
                                            <?php echo $c->modelo ?>
                                        </td>
                                        <td>
                                            <div class="actions-form table">
                                                <a href="editar-compressor.php?id=<?php echo $c->id ?>" class="editar bt-action table bt-edit"><span class="material-symbols-outlined">edit_square</span></a>
                                                <a href="#" rel="<?php echo $c->id ?>" class="excluir bt-action table bt-remove"><span class="material-symbols-outlined">delete</span></a>&nbsp;&nbsp;&nbsp;
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </main>


    <script>
        $(document).ready(function() {
            $('#i-compressor').addClass("active")
            $('#carregando').fadeOut();
            $('#conteudo').fadeIn();

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