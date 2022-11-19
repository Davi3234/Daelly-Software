<?php
$menuItens = [
    ["inicio", "painel.php", "#", "Início", "home", false],
    ["funcionario", "cadastro-funcionario.php", "funcionarios.php", "Funcionário", "group", true],
    ["funcao", "cadastro-funcao.php", "funcoes.php", "Função", "psychology", true],
    ["tipo", "cadastro-tipo.php", "tipos.php", "Tipo", "category", true],
    ["grupo", "cadastro-grupo.php", "grupos.php", "Grupo", "groups", true],
    ["maquina-costura", "cadastro-maquina-costura.php", "maquinas-costura.php", "Máquina de Costura", "tag", true],
    ["compressor", "cadastro-compressor.php", "compressores.php", "Compressor", "iron", true],
    ["manutencao", "cadastro-manutencao.php", "manutencoes.php", "Manutenção", "build", true]
];
?>

<div class="barra-lateral-content">
    <i class="line-division"></i>
    <?php foreach ($menuItens as $item) { ?>
        <div class="item-parent">
            <?php if ($item[5]) { ?>
                <div id="i-<?php echo $item[0] ?>" class="item-children header icon-content left"><span class="material-symbols-outlined"><?php echo $item[4] ?></span><?php echo $item[3] ?></div>
                <div id="i-expansive-<?php echo $item[0] ?>" class="item-children itens">
                    <a href="<?php echo $item[1] ?>" class="item icon-content left"><span class="material-symbols-outlined">library_add</span><span>Cadastro</span></a>
                    <a href="<?php echo $item[2] ?>" class="item icon-content left"><span class="material-symbols-outlined">list</span><span>Listagem</span></a>
                </div>
            <?php } else { ?>
                <a href="<?php echo $item[1] ?>" id="i-<?php echo $item[0] ?>" class="item-children header no-expansive icon-content left"><span class="material-symbols-outlined"><?php echo $item[4] ?></span><?php echo $item[3] ?></a>
            <?php } ?>
        </div>
    <?php } ?>
    <i class="line-division"></i>
</div>