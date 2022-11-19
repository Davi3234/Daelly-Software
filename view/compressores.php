<?php
require_once '../model/MaquinaCostura.php';
require_once '../model/DaoMaquinaCostura.php';
require_once '../control/ControlMaquinaCostura.php';
require_once '../model/MaquinaCosturaMapa.php';
require_once '../model/DaoMaquinaCosturaMapa.php';
require_once '../control/ControlMaquinaCosturaMapa.php';
require_once '../model/Compressor.php';
require_once '../model/DaoCompressor.php';
require_once '../control/ControlCompressor.php';
require_once '../model/Manutencao.php';
require_once '../model/DaoManutencao.php';
require_once '../control/ControlManutencao.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlCompressor();
$controlMan = new ControlManutencao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($controlMan->excluirByCompressor(addslashes($_POST['id']))) {
        if ($control->excluir(addslashes($_POST['id']))) {
            $mensagem = "Compressor excluído com sucesso";
            unset($_POST);
        } else {
            $erros = "";
            foreach ($control->getErros() as $e) {
                $erros = $erros . $e . "<br />";
            }
        }
    } else {
        $erros = "";
            foreach ($controlMan->getErros() as $e) {
                $erros = $erros . $e . "<br />";
            }
    }
}
$compressores = $control->listar();
?>

<html>

<head>
    <?php include "header.php" ?>
    <title>Lista de Compressores - Daelly Conffecções</title>
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
            <div class="carregando">
                Carregando...
            </div>

            <div class="conteudo">
                <div class="conteudo-header">
                    <h2>Compressores</h2>
                </div>

                <div class="conteudo-main">
                    <form action="" method="POST" id="form">
                        <input type="hidden" value="" name="id" id="id" />
                        <input type="hidden" value="" name="acao" id="acao" />

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

                        <div class="actions-form">
                            <a href="cadastro-compressor.php" type="submit" class="bt-action form primary icon-content rigth">Novo<span class="material-symbols-outlined">library_add</span></a>
                        </div>

                        <div class="line-division"></div>

                        <div class="table-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Ações</th>
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
                                                    <a href="#" rel="<?php echo $c->id ?>" class="excluir bt-action table bt-remove"><span class="material-symbols-outlined">delete</span></a>
                                                    <a href="manutencoes-por-compressor.php?id=<?php echo $c->id ?>" class="bt-action table bt-list"><span class="material-symbols-outlined">build</span></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#i-compressor').addClass("active")

            $(".excluir").click(function() {
                if (confirm("Deseja realmente excluir o registro?")) {
                    id = $(this).attr("rel")
                    $("#id").val(id)
                    $("#form").submit()
                }
            })
        })
    </script>
</body>

</html>