const mapa = document.getElementById("mapa")
const listaMCMapa = document.getElementById("lista-maquinas-mapa")
const listaMCInventario = document.getElementById("lista-maquinas-inventario")
const maquinaInfo = document.getElementById("maquina-info-content")
const btSalvarMaquinas = document.getElementById("bt-salvar-maquinas")
const btResetarMaquinas = document.getElementById("bt-resetar-maquinas")

function getMaquina({ codigo: cod1 }) {
    const { id, codigo, posicionado, x, y } = maquinas.find(({ codigo: cod2 }) => { return cod2 == cod1 })
    const tag = document.getElementById("maquina-" + codigo)

    return { maquina: { id, codigo, posicionado, x, y }, tag }
}

function addMaquinaAtualizada({ id, codigo, posicionado, x, y }) {
    maquinasAlteradas.push({ id, codigo, posicionado, x, y })
}

function removerMaquinaAtualizada(mc) {
    maquinasAlteradas.splice(mc, 1)
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
                return
            }
            // Mesma posição do mapa
            removerMaquinaAtualizada(mcInUpdate)
            return
        }
        // Do mapa/inventario para o inventário
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
        document.querySelectorAll("#lista-maquinas-mapa .maquinas").forEach(a => a.style.position = "absolute")
        document.querySelectorAll(".maquinas").forEach(a => {
            a.addEventListener("mouseenter", maquinaHoverIn)
            a.addEventListener("mouseout", maquinaHoverOut)
        })
        window.addEventListener("click", hiddenMaquinaInfo)
    }

    const resetarMaquinas = () => {
        while (maquinasAlteradas.length > 0) {
            const { maquina, tag } = getMaquina(maquinasAlteradas[0])

            if (maquina.posicionado == 0) addMaquinaInventario(tag)
            else addMaquinaMapa(tag, maquina.x, maquina.y)

            toggleBtActions()
        }
    }

    const maquinaHoverIn = (ev) => {
        showMaquinaInfo(ev)
    }

    const maquinaHoverOut = (ev) => {
        !maquinaInfo.classList.contains("active") && hiddenMaquinaInfo()
    }

    const maquinaDragClickDown = (ev) => {
        ev.dataTransfer.setData("text", ev.target.id)
        maquinaInfoToggle && hiddenMaquinaInfo()
    }

    const showMaquinaInfo = ({ target }) => {
        if (maquinaInfoToggle) { return }
        maquinaInfoToggle = true

        const { clientX: x, clientY: y } = target //

        maquinaInfo.style.left = x + "px"
        maquinaInfo.style.top = y + "px"

        setTimeout(() => {
            // maquinaInfo.classList.toggle("active", maquinaInfoToggle)
        }, 1500)
    }

    const toggleBtActions = () => {
        const isMaquinasAlteradas = maquinasAlteradas.length > 0

        btSalvarMaquinas.classList.toggle("valid", isMaquinasAlteradas)
        btResetarMaquinas.classList.toggle("valid", isMaquinasAlteradas)
    }

    const hiddenMaquinaInfo = () => {
        maquinaInfoToggle = false
        maquinaInfo.classList.toggle("active", maquinaInfoToggle)
    }

    const maquinaDragMove = (ev) => {
        ev.preventDefault()
    }

    const maquinaDragClickUpMapa = (ev) => {
        ev.preventDefault()
        const tag = document.getElementById("" + ev.dataTransfer.getData("text"))

        addMaquinaMapa(tag, ev.offsetX - (tag.clientWidth / 2), ev.offsetY - (tag.clientHeight / 2))
        toggleBtActions()
    }

    const maquinaDragClickUpInventario = (ev) => {
        ev.preventDefault()
        const tag = document.getElementById("" + ev.dataTransfer.getData("text"))

        addMaquinaInventario(tag)
        toggleBtActions()
    }

    const addMaquinaMapa = (tag, x, y) => {
        if (x <= 0 || x >= mapa.clientWidth + tag.clientWidth || y <= 0 || y >= mapa.clientHeight + tag.clientHeight) {
            addMaquinaInventario(tag)
            return
        }
        const { maquina } = getMaquina({ codigo: tag.id.substring(8) })

        maquina.posicionado = 1
        updatePosition(tag, maquina, x, y)

        tag.style.position = "absolute"

        listaMCMapa.appendChild(tag)

        atualizarListaMaquinasAlteradas(maquina)
    }

    const addMaquinaInventario = (tag) => {
        const { maquina } = getMaquina({ codigo: tag.id.substring(8) })

        maquina.posicionado = 0
        updatePosition(tag, maquina, 0, 0)

        tag.style.position = "relative"

        listaMCInventario.appendChild(tag)

        atualizarListaMaquinasAlteradas(maquina)
    }

    const updatePosition = (tag, maquina, x, y) => {
        maquina.x = x
        maquina.y = y

        tag.style.left = x + "px"
        tag.style.top = y + "px"
    }

    iniciarComponents()

    return {
        maquinaDragMove,
        maquinaDragClickDown,
        maquinaDragClickUpMapa,
        maquinaDragClickUpInventario,
        resetarMaquinas
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
