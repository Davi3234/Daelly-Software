<?php
require_once '../model/Funcao.php';
require_once '../model/DaoFuncao.php';
require_once '../control/ControlFuncao.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlFuncao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->excluir(addslashes($_POST['id']))) {
        $mensagem = "Função excluída com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$funcoes = $control->listar();
?>

<html>

<head>
    <?php include "head.php" ?>
    <title>Lista de Funções - Daelly Conffecções</title>
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
                    <h2>Funções</h2>
                </div>
                <div class="line-division"></div>

                <div class="conteudo-main">
                    <form action="" method="POST" id="form">
                        <input type="hidden" value="" name="id" id="id" />
                        <input type="hidden" value="" name="acao" id="acao" />

                        <?php if (isset($mensagem)) { ?>
                            <div class="alert alert-success">
                                <?php echo $mensagem; ?>
                                <div class="close-alert">X</div>
                            </div>
                        <?php } ?>

                        <?php if (isset($erros)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $erros; ?>
                                <div class="close-alert">X</div>
                            </div>
                        <?php } ?>

                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($funcoes) foreach ($funcoes as $f) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $f->nome ?>
                                        </td>
                                        <td>
                                            <?php echo $f->tipo ?>
                                        </td>
                                        <td>
                                            <div class="actions-form table">
                                                <a href="editar-funcao.php?id=<?php echo $f->id ?>" class="editar bt-action table bt-edit"><span class="material-symbols-outlined">edit_square</span></a>
                                                <a href="#" rel="<?php echo $f->id ?>" class="excluir bt-action table bt-remove"><span class="material-symbols-outlined">delete</span></a>&nbsp;&nbsp;&nbsp;
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
            $('#i-funcao').addClass("active")
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