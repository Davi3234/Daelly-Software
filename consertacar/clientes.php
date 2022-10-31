<?php
require_once './model/Cliente.php';
require_once './model/DaoCliente.php';
require_once './control/ControlCliente.php';
session_start();
if (!isset($_SESSION['email']))  {
    header("location: login.php");
}
$control = new ControlCliente();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($control->excluir(addslashes($_POST['id']))) {
        $mensagem = "Cliente excluído com sucesso";
        unset($_POST);
    } else {
        $erros = "";
        foreach ($control->getErros() as $e) {
            $erros = $erros . $e . "<br />";
        }
    }
}

$clientes = $control->listar();
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema de Gerenciamento de Conteúdo</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <link href="css/datepicker3.css" rel="stylesheet">
        <link href="css/bootstrap-table.css" rel="stylesheet">
        <script src="js/jquery-3.1.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-table.js"></script>
        <script src="js/bootbox.js"></script>
        <script src="js/lumino.glyphs.js"></script>      
        <script src="js/jquery-maskedinput.min.js"></script>      
        <script src="js/mascaras.js"></script>      
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
                    <a class="navbar-brand" href="">ConsertaCar</a>
                    <ul class="user-menu">
                        <li class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg><span class="nome_usuario">Usuário Logado </span><span class="caret"></span>                                    
                            </a>
                            <ul class="dropdown-menu" role="menu">                                
                                <li><a href="logout.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        
        <?php include'nome.php'?>

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">            
            <div id="carregando">
                Carregando...                        
            </div>
            <div id="conteudo">               

                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                        <li class="active">Clientefa-stack</li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Clientes</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <form action="" method="POST" id="form">
                                    <input type="hidden" value="" name="id" id="id"/>
                                    <input type="hidden" value="" name="acao" id="acao"/>

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

                                    <table data-toggle="table" data-show-refresh="true" data-id-field="1" data-show-toggle="true" data-show-columns="false" data-search="true" data-select-item-name="selecionados[]" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                                        <thead>
                                            <tr>                                                
                                                <th data-sortable="true">Id</th>
                                                <th data-sortable="true">Nome</th> 
                                                <th data-sortable="true">CPF</th> 
                                                <th data-sortable="true">Email</th> 
                                                <th data-sortable="true">Telefone</th> 
                                                <th data-sortable="true">Data de nascimento</th> 
                                                <th data-sortable="true">Acções</th>                                             
                                            </tr>                        
                                        </thead>  
                                        <tbody> 
                                            <?php if ($clientes) foreach ($clientes as $c) { ?>
                                                    <tr>
                                                        <td><?php echo $c->id ?></td>                                                        
                                                        <td><?php echo $c->nome ?></td>    
                                                        <td><?php echo $c->cpf ?></td> 
                                                        <td><?php echo $c->email ?></td> 
                                                        <td><?php echo $c->telefone ?></td>    
                                                        <td><?php echo $c->data_nascimento ?></td>                                                       
                                                        <td>
                                                            <a href="#" class="editar" rel="<?php echo $c->id ?>">Editar</a>&nbsp;&nbsp;&nbsp;
                                                            <a href="#" class="excluir" rel="<?php echo $c->id ?>">Excluir</a>
                                                        </td>                                                        
                                                    </tr>
                                                <?php } ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>		
                        </div>
                    </div>
                </div>

            </div>            
        </div>

        <script>
            !function ($) {
                $(document).on("click", "ul.nav li.parent > a > span.icon", function () {
                    $(this).find('em:first').toggleClass("glyphicon-minus");
                });
                $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
            }(window.jQuery);

            $(window).on('resize', function () {
                if ($(window).width() > 768)
                    $('#sidebar-collapse').collapse('show')
            })
            $(window).on('resize', function () {
                if ($(window).width() <= 767)
                    $('#sidebar-collapse').collapse('hide')
            })

        </script>
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('#carregando').fadeOut();
                $('#conteudo').fadeIn();

                $(".editar").click(function () {
                    id = $(this).attr("rel");
                    $(location).attr("href", "editar-cliente.php?id=" + id);
                });

                $(".excluir").click(function () {
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