<?php
require_once '../model/Funcionario.php';
require_once '../model/DaoFuncionario.php';
require_once '../control/ControlFuncionario.php';
require_once '../model/FuncionarioFuncao.php';
require_once '../model/DaoFuncionarioFuncao.php';
require_once '../control/ControlFuncionarioFuncao.php';
require_once '../model/Grupo.php';
require_once '../model/DaoGrupo.php';
require_once '../control/ControlGrupo.php';
require_once '../model/Funcao.php';
require_once '../model/DaoFuncao.php';
require_once '../control/ControlFuncao.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
}
$control = new ControlFuncionario();
$controlGru = new ControlGrupo();
$controlFun = new ControlFuncao();
$controlFF = new ControlFuncionarioFuncao();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $funcoesSelecionadas = json_decode($_POST["funcoes-selecionadas"])->funcoes;

    if ($control->editar(addslashes($_GET['id']), $_POST['cpf'], $_POST['nome'], $_POST['entrada'], $_POST['saida'], $_POST['id_grupo'])) {
        $mensagem = "Funcionário editado com sucesso";

        $control->vincularFuncoes($control->selecionarByCpf($_POST["cpf"], $funcoesSelecionadas)->id, $funcoesSelecionadas);
        unset($_POST);
    }
    if (count($control->getErros()) > 0) {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}
$listaGru = $controlGru->listar();
$listaFun = $controlFun->listar();
$listaFuncaInFunci = array();
foreach($controlFF->listarByFuncionario(addslashes($_GET['id'])) as $f){
    $listaFuncaInFunci[] = $f['id_funcao'];
}
$funcionario = $control->selecionar(addslashes($_GET['id']));
?>

<html>

<head>
<?php include 'header.php' ?>
</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Daelly Confec��es</a>
                <ul class="user-menu">
                    <li class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <svg class="glyph stroked male-user">
                                <use xlink:href="#stroked-male-user"></use>
                            </svg><span class="nome_usuario">Usu�rio Logado </span><span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="logout.php"><svg class="glyph stroked cancel">
                                        <use xlink:href="#stroked-cancel"></use>
                                    </svg> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <?php include 'nome.php' ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div id="carregando">
            Carregando...
        </div>
        <div id="conteudo">

            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="index.php"><svg class="glyph stroked home">
                                <use xlink:href="#stroked-home"></use>
                            </svg></a></li>
                    <li class="active">Funcion�rios</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Funcion�rios</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <form action="" method="POST" id="form" name="form">
                            <input hidden type="text" name="funcoes-selecionadas" id="funcoes-input" value='{"funcoes":[]}'>
                            <div class="panel-heading">
                                <button type="submit" id="gravar" class="btn btn-primary" data-toggle="tooltip" title="Gravar o registro" data-placement="auto"><svg class="glyph stroked checkmark">
                                        <use xlink:href="#stroked-checkmark" />
                                    </svg> Gravar</button>
                                <button type="button" class="btn btn-primary voltar" data-toggle="tooltip" title="Voltar para a listagem" data-placement="auto"><svg class="glyph stroked arrow left">
                                        <use xlink:href="#stroked-arrow-left" />
                                    </svg> Voltar</button>
                            </div>
                            <div class="panel-body">

                                <?php if (isset($mensagem)) { ?>
                                    <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">X</a>
                                        <?php echo $mensagem; ?>
                                    </div>
                                <?php } ?>

                                <?php if (isset($erros)) { ?>
                                    <div class="alert alert-danger">
                                        <?php echo $erros; ?>
                                    </div>
                                <?php } ?>

                                <div class="campo_esquerda">
                                    <input type="text" class="form-control" value="<?php echo $funcionario->nome ?>" name="nome" id="nome" placeholder="Informe o nome" required="required" data-toggle="tooltip" title="Informe o nome" data-placement="auto" />
                                </div>
                                <div class="campo_direita">
                                    <input type="text" class="form-control" value="<?php echo $funcionario->cpf ?>" name="cpf" id="cpf" placeholder="Informe o CPF" required="required" data-toggle="tooltip" title="Informe o CPF" data-placement="auto" />
                                </div>
                                <div class="campo_esquerda">
                                    <input type="date" class="form-control" value="<?php echo $funcionario->entrada ?>" name="entrada" id="entrada" placeholder="Informe a data de entrada" required="required" data-toggle="tooltip" title="Informe a data de entrada" data-placement="auto" />
                                </div>
                                <div class="campo_direita">
                                    <input type="date" class="form-control" value="<?php echo $funcionario->saida ?>" name="saida" id="saida" placeholder="Informe a data de sa�da" data-toggle="tooltip" title="Informe a data de sa�da" data-placement="auto" />
                                </div>
                                <div class="form-check campo_esquerda">
                                    <?php foreach ($listaFun as $f) { ?>
                                        <input <?php if (in_array($f->id, $listaFuncaInFunci)) { ?> checked <?php } ?> name="funcoes[]" class="form-check-input" type="checkbox" value="<?php echo $f->id ?>" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault"><?php echo $f->nome ?></label>
                                        <br>
                                    <?php } ?>
                                </div>
                                <div class="campo_direita">
                                    <select class="form-control" id="id_grupo" name="id_grupo">
                                        <option value="0">Selecione</option>
                                        <?php
                                        foreach ($listaGru as $g) {
                                        ?>
                                            <option <?php if ($g->id == $funcionario->id_grupo) { ?> selected <?php } ?> value="<?php echo $g->id ?>"><?php echo $g->numero ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script>
        ! function($) {
            $(document).on("click", "ul.nav li.parent > a > span.icon", function() {
                $(this).find('em:first').toggleClass("glyphicon-minus");
            });
            $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
            $(".parent#menu-item-funcionario").addClass("active");
        }(window.jQuery);

        $(window).on('resize', function() {
            if ($(window).width() > 768)
                $('#sidebar-collapse').collapse('show')
        })
        $(window).on('resize', function() {
            if ($(window).width() <= 767)
                $('#sidebar-collapse').collapse('hide')
        })
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#carregando').fadeOut();
            $('#conteudo').fadeIn();

            $(".voltar").click(function() {
                $(location).attr("href", "funcionarios.php");
            });

            $('#form').submit((ev) => {
                // ev.preventDefault()
                const funcoesSelecionadas = []
                document.getElementsByName("funcoes[]").forEach(tag => {
                    if (!tag.checked) {
                        return
                    }
                    funcoesSelecionadas.push(Number(tag.value))
                })

                const data = `{"funcoes":${JSON.stringify(funcoesSelecionadas)}}`

                console.log(data);

                document.getElementById("funcoes-input").value = data

            })
        });
        $(document).ready(function() {
            $("#cpf").mask("999.999.999-99");
        });
    </script>

</body>

</html>