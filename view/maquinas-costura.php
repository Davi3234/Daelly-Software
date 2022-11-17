<?php
require_once '../model/MaquinaCostura.php';
require_once '../model/DaoMaquinaCostura.php';
require_once '../control/ControlMaquinaCostura.php';
require_once '../model/MaquinaCosturaMapa.php';
require_once '../model/DaoMaquinaCosturaMapa.php';
require_once '../control/ControlMaquinaCosturaMapa.php';
require_once '../model/Tipo.php';
require_once '../model/DaoTipo.php';
require_once '../control/ControlTipo.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlMaquinaCostura();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->excluir(addslashes($_POST['id']))) {
        $mensagem = "Máquina de costura excluída com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$maquinas = $control->listar();
?>

<html>

<head>
    <?php include "header.php" ?>
    <title>Lista de Máquinas de Costura - Daelly Conffecções</title>
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
                    <h2>Máquinas de Costura</h2>
                </div>
                <div class="line-division"></div>

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

                        <div class="table-content">
<table>
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Modelo</th>
                                    <th>Marca</th>
                                    <th>Chassi</th>
                                    <th>Data de Aquisição</th>
                                    <th>Tipo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($maquinas) foreach ($maquinas as $m) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $m->codigo ?>
                                        </td>
                                        <td>
                                            <?php echo $m->modelo ?>
                                        </td>
                                        <td>
                                            <?php echo $m->marca ?>
                                        </td>
                                        <td>
                                            <?php echo $m->chassi ?>
                                        </td>
                                        <td>
                                            <?php echo $m->aquisicao ?>
                                        </td>
                                        <td>
                                            <?php echo $m->tipo ?>
                                        </td>
                                        <td>
                                            <div class="actions-form table">
                                                <a href="editar-maquina-costura.php?id=<?php echo $m->id ?>" class="editar bt-action table bt-edit"><span class="material-symbols-outlined">edit_square</span></a>
                                                <a href="#" rel="<?php echo $m->id ?>" class="excluir bt-action table bt-remove"><span class="material-symbols-outlined">delete</span></a>   
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
            $('#i-maquina-costura').addClass("active")
            $('#carregando').fadeOut();
            $('.conteudo').fadeIn();

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