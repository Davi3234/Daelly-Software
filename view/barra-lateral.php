<?php
$menuItens = [
    ["inicio", "painel.php", "#", "Início", "home", "", "", false],
    ["tipo", "cadastro-tipo.php", "tipos.php", "Tipo", "category", "Novo tipo", "Tipos", true],
    ["funcao", "cadastro-funcao.php", "funcoes.php", "Função", "psychology", "Nova função", "Funções", true],
    ["grupo", "cadastro-grupo.php", "grupos.php", "Grupo", "groups", "Novo grupo", "Grupos", true],
    ["funcionario", "cadastro-funcionario.php", "funcionarios.php", "Funcionário", "group", "Novo funcionário", "Funcionários", true],
    ["maquina-costura", "cadastro-maquina-costura.php", "maquinas-costura.php", "Máquina de Costura", "tag", "Nova máquina de costura", "Máquinas de Costura", true],
    ["compressor", "cadastro-compressor.php", "compressores.php", "Compressor", "iron", "Novo compressor", "Compressores", true],
    ["manutencao", "cadastro-manutencao.php", "manutencoes.php", "Manutenção", "build", "Nova manutenção", "Manutenções", true],
];
?>

<div class="barra-lateral-content">
    <i class="line-division"></i>
    <?php foreach ($menuItens as $item) { ?>
        <div class="item-parent">
            <?php if ($item[7]) { ?>
                <div id="i-<?php echo $item[0] ?>" class="item-children header icon-content left"><span class="material-symbols-outlined"><?php echo $item[4] ?></span><span><?php echo $item[3] ?></span></div>
                <div id="i-expansive-<?php echo $item[0] ?>" class="item-children itens">
                    <a href="<?php echo $item[2] ?>" class="item icon-content left"><span class="material-symbols-outlined">list</span><span><?php echo $item[6] ?></span></a>
                    <a href="<?php echo $item[1] ?>" class="item icon-content left"><span class="material-symbols-outlined">library_add</span><span><?php echo $item[5] ?></span></a>
                </div>
            <?php } else { ?>
                <a href="<?php echo $item[1] ?>" id="i-<?php echo $item[0] ?>" class="item-children header no-expansive icon-content left"><span class="material-symbols-outlined"><?php echo $item[4] ?></span><span><?php echo $item[3] ?></span></a>
            <?php } ?>
        </div>
    <?php } ?>
    <i class="line-division"></i>
</div>