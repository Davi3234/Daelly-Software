<?php
require_once '../../model/Tipo.php';
require_once '../../model/DaoTipo.php';
require_once '../../control/ControlTipo.php';
require_once '../../model/MaquinaCostura.php';
require_once '../../model/DaoMaquinaCostura.php';
require_once '../../control/ControlMaquinaCostura.php';
require_once '../../model/MaquinaCosturaMapa.php';
require_once '../../model/DaoMaquinaCosturaMapa.php';
require_once '../../control/ControlMaquinaCosturaMapa.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlMaquinaCostura();
$controlTipo = new ControlTipo();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->excluir(addslashes($_POST['id']))) {
        $mensagem = "Máquina de costura excluído com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}

$tipo = $controlTipo->selecionar(addslashes($_GET["id"]));
$maquinas = $control->listarByTipo($tipo->id);
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
            <div class="carregando">
                Carregando...
            </div>

            <div class="conteudo">
                <div class="conteudo-header">
                    <h2>Máquinas de Costura do tipo <?php echo $tipo->nome ?></h2>
                </div>
                <div class="line-division"></div>

                <div class="actions-form">
                    <a href="cadastro-maquina-costura.php?tipo=<?php echo $tipo->id ?>" class="bt-action form primary icon-content rigth">Novo<span class="material-symbols-outlined">library_add</span></a>
                    <button type="submit" class="bt-action form primary icon-content rigth voltar">Voltar<span class="material-symbols-outlined">redo</span></button>
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
                                        <th>Código</th>
                                        <th>Modelo</th>
                                        <th>Marca</th>
                                        <th>Chassi</th>
                                        <th>Data de Aquisição</th>
                                        <th style="width: 13rem;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="table-results">
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
                                                <div class="actions-form table">
                                                    <a href="editar-maquina-costura.php?id=<?php echo $m->id ?>" class="editar bt-action table bt-edit tooltip-content"><span class="material-symbols-outlined">edit_square</span><span class="tooltip">Editar máquina de costura</span></a>
                                                    <a href="manutencoes-por-maquina.php?id=<?php echo $m->id ?>" class="bt-action table bt-list tooltip-content"><span class="material-symbols-outlined">build</span><span class="tooltip">Manutenções dessa máquina de costura</span></a>
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
            $('#i-tipo').addClass("active")
        });
    </script>

</body>

</html>