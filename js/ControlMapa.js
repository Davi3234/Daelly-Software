const mapa = document.getElementById("mapa")
const listaMCMapa = document.getElementById("lista-maquinas-mapa")
const listaMCInventario = document.getElementById("lista-maquinas-inventario")
const maquinaInfo = document.getElementById("maquina-info-content")
const btSalvarMaquinas = document.getElementById("bt-salvar-maquinas")
const btResetarMaquinas = document.getElementById("bt-resetar-maquinas")
const btGuardarMaquinas = document.getElementById("bt-guardar-maquinas")

function getMaquina({ codigo: cod1 }) {
    const { id, codigo, posicionado, x, y, tipo, id_maquina_costura, chassi, modelo, marca, aquisicao } = maquinas.find(({ codigo: cod2 }) => { return cod2 == cod1 })
    const tag = document.getElementById("maquina-" + codigo)

    return { maquina: { id, codigo, posicionado, x, y, tipo, id_maquina_costura, chassi, modelo, marca, aquisicao }, tag }
}

function addMaquinaAtualizada({ id, codigo, posicionado, x, y }) {
    maquinasAlteradas.push({ id, codigo, posicionado, x, y })
}

function removerMaquinaAtualizada({ codigo }) {
    maquinasAlteradas.splice(maquinasAlteradas.map(m => m.codigo).indexOf(codigo), 1)
}

function atualizarListaMaquinasAlteradas(mcChanged) {
    const { maquina: mcOrigin } = getMaquina(mcChanged)
    const mcInUpdate = maquinasAlteradas.find(m => m.codigo == mcChanged.codigo)

    if (!mcInUpdate) { // Primeira alteração da máquina
        if (mcChanged.posicionado == mcOrigin.posicionado && mcOrigin.posicionado == 0) { // Do inventário para o inventário
            return
        }
        // Do inventário para o mapa e vice-versa / Do mapa para o mapa
        addMaquinaAtualizada(mcChanged)
        return
    }

    if (mcChanged.posicionado == mcOrigin.posicionado) {
        if (mcOrigin.posicionado == 1) { // Do mapa para o mapa
            if (mcChanged.x != mcOrigin.x || mcChanged.y != mcOrigin.y) { // Alterou a posição
                mcInUpdate.x = mcChanged.x
                mcInUpdate.y = mcChanged.y
                mcInUpdate.posicionado = 1
                return
            }
            // Mesma posição do mapa
            removerMaquinaAtualizada(mcInUpdate)
            return
        }
        // Do inventario para o inventário
        removerMaquinaAtualizada(mcInUpdate)
        return
    }

    // Do mapa para o inventario e vice-versa
    if (mcChanged.posicionado == 1) { // Do inventário para o mapa
        if (mcChanged.x != mcOrigin.x || mcChanged.y != mcOrigin.y) { // Alterou a posição
            mcInUpdate.x = mcChanged.x
            mcInUpdate.y = mcChanged.y
            return
        }
        // Mesma posição do mapa
        removerMaquinaAtualizada(mcInUpdate)
        return
    }

    // Do mapa para o inventário
    mcInUpdate.posicionado = 0
    mcInUpdate.x = 0
    mcInUpdate.y = 0
    return
}

function ControlMapa() {
    let maquinaInfoToggle = false

    const iniciarComponents = () => {
        maquinaInfoToggle = false
        document.querySelector(".close-info").addEventListener("click", hiddenMaquinaInfo)
        document.querySelectorAll("#lista-maquinas-mapa .maquinas").forEach(a => a.style.position = "absolute")
        document.querySelectorAll(".maquinas").forEach(a => {
            a.addEventListener("mouseout", maquinaHoverOut)
            a.addEventListener("click", showMaquinaInfo)
        })
        toggleBtActions()
    }

    const resetarMaquinas = () => {
        while (maquinasAlteradas.length > 0) {
            const { maquina, tag } = getMaquina(maquinasAlteradas[0])

            if (maquina.posicionado == 0) addMaquinaInventario(tag)
            else addMaquinaMapa(tag, maquina.x, maquina.y)

            toggleBtActions()
        }
    }

    const maquinaHoverOut = (ev) => {
        !maquinaInfo.classList.contains("active") && hiddenMaquinaInfo()
    }

    const maquinaDragClickDown = (ev) => {
        ev.dataTransfer.setData("text", ev.target.id)
        maquinaInfoToggle && hiddenMaquinaInfo()
    }

    const showMaquinaInfo = ({ target }) => {
        const { maquina } = getMaquina({ codigo: target.id.substring(8) })

        document.getElementById("mc-info-codigo").innerHTML = maquina.codigo
        document.getElementById("mc-info-tipo").innerHTML = maquina.tipo
        document.getElementById("mc-info-chassi").innerHTML = maquina.chassi
        document.getElementById("mc-info-modelo").innerHTML = maquina.modelo
        document.getElementById("mc-info-marca").innerHTML = maquina.marca
        document.getElementById("mc-info-aquisicao").innerHTML = maquina.aquisicao
        document.getElementById("id_maquina_costura").value = maquina.id_maquina_costura
        document.getElementById("id_maquina_costura_mapa").value = maquina.id

        const mc = maquinasAlteradas.find(({ codigo }) => { return codigo == maquina.codigo })
        document.getElementById("bt-guardar-maquina").classList.toggle("active", mc ? mc.posicionado == 1 : maquina.posicionado == 1)

        maquinaInfo.classList.toggle("active", true)
    }

    const toggleBtActions = () => {
        const isMaquinasAlteradas = maquinasAlteradas.length > 0

        btSalvarMaquinas.classList.toggle("valid", isMaquinasAlteradas)
        btResetarMaquinas.classList.toggle("valid", isMaquinasAlteradas)
        btGuardarMaquinas.classList.toggle("valid", document.querySelectorAll("#lista-maquinas-mapa .maquinas").length > 0)
    }

    const hiddenMaquinaInfo = () => {
        maquinaInfo.classList.toggle("active", maquinaInfoToggle)
    }

    const maquinaDragMove = (ev) => {
        ev.preventDefault()
    }

    const maquinaDragClickUpMapa = (ev) => {
        ev.preventDefault()
        const tag = document.getElementById("" + ev.dataTransfer.getData("text"))
        addMaquinaMapa(tag, ev.offsetX - (dimensao.maquina.largura / 2), ev.offsetY - (dimensao.maquina.altura / 2))
    }

    const maquinaDragClickUpInventario = (ev) => {
        ev.preventDefault()
        const tag = document.getElementById("" + ev.dataTransfer.getData("text"))
        addMaquinaInventario(tag)
    }

    const addMaquinaMapa = (tag, x, y) => {
        if (x <= 0 || x >= dimensao.mapa.largura - tag.clientWidth || y <= 0 || y >= dimensao.mapa.altura - tag.clientHeight) {
            addMaquinaInventario(tag)
            return
        }
        const { maquina } = getMaquina({ codigo: tag.id.substring(8) })

        maquina.posicionado = 1
        updatePosition(tag, maquina, x, y)

        tag.style.position = "absolute"

        listaMCMapa.appendChild(tag)

        atualizarListaMaquinasAlteradas(maquina)
        toggleBtActions()
        maquinaInfo.classList.contains("active") && showMaquinaInfo({ target: tag })
    }

    const addMaquinaInventario = (tag) => {
        const { maquina } = getMaquina({ codigo: tag.id.substring(8) })

        maquina.posicionado = 0
        updatePosition(tag, maquina, 0, 0)

        tag.style.position = "relative"

        listaMCInventario.appendChild(tag)

        atualizarListaMaquinasAlteradas(maquina)
        toggleBtActions()
        maquinaInfo.classList.contains("active") && showMaquinaInfo({ target: tag })
    }

    const updatePosition = (tag, maquina, x, y) => {
        maquina.x = x
        maquina.y = y

        tag.style.left = x + "px"
        tag.style.top = y + "px"
    }

    const guardarMaquinas = () => {
        document.querySelectorAll(".maquinas").forEach(a => addMaquinaInventario(a))
        maquinaInfo.classList.toggle("active", false)
    }

    const guardarMaquina = () => {
        addMaquinaInventario(document.querySelector(".maquinas#maquina-" + String(document.getElementById("mc-info-codigo").innerHTML)))
    }

    iniciarComponents()

    return {
        maquinaDragMove,
        maquinaDragClickDown,
        maquinaDragClickUpMapa,
        maquinaDragClickUpInventario,
        resetarMaquinas,
        guardarMaquinas,
        guardarMaquina,
    }
}

let control = null

window.onload = () => {
    control = ControlMapa()
}

function allowDrop(ev) {
    control && control.maquinaDragMove(ev)
}

function drag(ev) {
    control && control.maquinaDragClickDown(ev)
}

function dropMapa(ev) {
    control && control.maquinaDragClickUpMapa(ev)
}

function dropInventario(ev) {
    control && control.maquinaDragClickUpInventario(ev)
}

function resetarMaquinasAlteradas() {
    control && control.resetarMaquinas()
}

function guardarMaquinas() {
    control && control.guardarMaquinas()
}

function guardarMaquina() {
    control && control.guardarMaquina()
}
