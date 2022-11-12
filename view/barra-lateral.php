<div class="barra-lateral-content">
    <i class="line-division"></i>
    <div class="menu-item-parent">
        <div id="i-inicio" class="item-children header no-expansive">Início</div>
    </div>
    <div class="menu-item-parent">
        <div id="i-funcionario" class="item-children header">Funcionários</div>
        <div id="i-expansive-funcionario" class="item-children itens">
            <a href="cadastro-funcionario.php" class="item"><span>Cadastro</span></a>
            <a href="funcionarios.php" class="item"><span>Listagem</span></a>
        </div>
    </div>
    <div class="menu-item-parent">
        <div id="i-funcao" class="item-children header">Funções</div>
        <div id="i-expansive-funcao" class="item-children itens">
            <a href="cadastro-funcao.php" class="item"><span>Cadastro</span></a>
            <a href="funcoes.php" class="item"><span>Listagem</span></a>
        </div>
    </div>
    <div class="menu-item-parent">
        <div id="i-tipo" class="item-children header">Tipos</div>
        <div id="i-expansive-tipo" class="item-children itens">
            <a href="cadastro-tipo.php" class="item"><span>Cadastro</span></a>
            <a href="tipos.php" class="item"><span>Listagem</span></a>
        </div>
    </div>
    <div class="menu-item-parent">
        <div id="i-grupo" class="item-children header">Grupos</div>
        <div id="i-expansive-grupo" class="item-children itens">
            <a href="cadastro-grupo.php" class="item"><span>Cadastro</span></a>
            <a href="grupos.php" class="item"><span>Listagem</span></a>
        </div>
    </div>
    <div class="menu-item-parent">
        <div id="i-maquina-costura" class="item-children header">Máquinas de Costura</div>
        <div id="i-expansive-maquina-costura" class="item-children itens">
            <a href="cadastro-maquina-costura.php" class="item"><span>Cadastro</span></a>
            <a href="maquinas-costura.php" class="item"><span>Listagem</span></a>
        </div>
    </div>
    <div class="menu-item-parent">
        <div id="i-compressor" class="item-children header">Compressores</div>
        <div id="i-expansive-compressor" class="item-children itens">
            <a href="cadastro-compressor.php" class="item"><span>Cadastro</span></a>
            <a href="compressores.php" class="item"><span>Listagem</span></a>
        </div>
    </div>
    <div class="menu-item-parent">
        <div id="i-manutencao" class="item-children header">Manutenções</div>
        <div id="i-expansive-manutencao" class="item-children itens">
            <a href="#" class="item"><span>Cadastro</span></a>
            <a href="#" class="item"><span>Listagem</span></a>
        </div>
    </div>
    <i class="line-division"></i>
</div>

<script>
    document.querySelectorAll(".item-children.header").forEach(a => a.addEventListener("click", ({target}) => {
        if (target.classList.contains("no-expansive")) {return}
        const tag = document.querySelector(".item-children.itens#i-expansive-" + (target.id.substr(2)))
        if (!tag) {return}
        tag.classList.toggle("active");
    }))
</script>