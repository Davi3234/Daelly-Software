<?php
require_once '../model/MaquinaCostura.php';
require_once '../model/DaoMaquinaCostura.php';
require_once '../control/ControlMaquinaCostura.php';
require_once '../model/Manutencao.php';
require_once '../model/DaoManutencao.php';
require_once '../control/ControlManutencao.php';
require_once '../model/Compressor.php';
require_once '../model/DaoCompressor.php';
require_once '../control/ControlCompressor.php';
require_once '../model/MaquinaCosturaMapa.php';
require_once '../model/DaoMaquinaCosturaMapa.php';
require_once '../control/ControlMaquinaCosturaMapa.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlManutencao();
$controlCom = new ControlCompressor();

$compressor = $controlCom->selecionar(addslashes($_GET["id"]));
$manutencoes = $control->listarByCompressor($compressor->id);
?>

<html>

<head>
    <?php include "header.php" ?>
    <title>Lista de Manutenções - Daelly Conffecções</title>
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
                    <h2>Manutenções do compressor <?php echo $compressor->codigo ?></h2>
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
                            <a href="cadastro-manutencao.php?compressor=<?php echo $compressor->id ?>" type="submit" class="bt-action form primary icon-content rigth">Novo<span class="material-symbols-outlined">library_add</span></a>
                            <button type="button" class="bt-action form primary voltar icon-content rigth">Voltar<span class="material-symbols-outlined">redo</span></button>
                        </div>

                        <div class="line-division"></div>

                        <div class="table-content">
                            <div class="fill-inputs">
                                  <div class="input-box input-position-left">
                                    <input type="text" name="filter-table" id="filter-table" autocomplete="off" />
                                    <label for="filter-table">Busca</label>
                                    <i></i>
                                </div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Data Manutenção</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="table-results">
                                    <?php
                                    foreach ($manutencoes as $m) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $m->descricao ?>
                                            </td>
                                            <td>
                                                <?php echo $m->data_manutencao ?>
                                            </td>
                                            <td>
                                                <div class="actions-form table">
                                                    <a href="editar-manutencao.php?id=<?php echo $m->id ?>" class="editar bt-action table bt-edit tooltip-content"><span class="material-symbols-outlined">edit_square</span><span class="tooltip">Editar manutenção</span></a>
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
                    id = $(this).attr("rel");
                    $("#id").val(id);
                    $("#form").submit();
                }
            });

        });
    </script>

</body>

</html>