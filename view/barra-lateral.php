<?php
$menuItens = [
    ["inicio", "painel.php", "#", "Início", false],
    ["funcionario", "cadastro-funcionario.php", "funcionarios.php", "Funcionário", true],
    ["funcao", "cadastro-funcao.php", "funcoes.php", "Função", true],
    ["tipo", "cadastro-tipo.php", "tipos.php", "Tipo", true],
    ["grupo", "cadastro-grupo.php", "grupos.php", "Grupo", true],
    ["maquina-costura", "cadastro-maquina-costura.php", "maquinas-costura.php", "Máquina Costura", true],
    ["compressor", "cadastro-compressor.php", "compressores.php", "Compressor", true],
    ["manutencao", "cadastro-manutencao.php", "manutencoes.php", "Manutenção", true]
];
?>

<div class="barra-lateral-content">
    <i class="line-division"></i>
    <?php foreach ($menuItens as $item) { ?>
        <div class="item-parent">
            <?php if ($item[4]) { ?>
                <div id="i-<?php echo $item[0] ?>" class="item-children header"><span class="icon material-symbols-outlined">expand_more</span> <?php echo $item[3] ?></div>
                <div id="i-expansive-<?php echo $item[0] ?>" class="item-children itens">
                    <a href="<?php echo $item[1] ?>" class="item"><span>Cadastro</span></a>
                    <a href="<?php echo $item[2] ?>" class="item"><span>Listagem</span></a>
                </div>
            <?php } else { ?>
                <a href="<?php echo $item[1] ?>" id="i-<?php echo $item[0] ?>" class="item-children header no-expansive"><span class="icon material-symbols-outlined" style="font-size: 2rem;">home</span> <?php echo $item[3] ?></a>
            <?php } ?>
        </div>
    <?php } ?>
    <i class="line-division"></i>
</div>