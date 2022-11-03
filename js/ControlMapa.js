const mapa = document.getElementById("mapa")
const listaMCMapa = document.getElementById("lista-maquinas-mapa")
const listaMCInventario = document.getElementById("lista-maquinas-inventario")
const maquinaInfo = document.getElementById("maquina-info-content")

const mapaDimension = { width: 1000, height: 1000 }

mapa.style.width = mapaDimension.width + "px"
mapa.style.height = mapaDimension.height + "px"

function getMaquina({ id }) {
    let maquina = null
    Object.keys(maquinas).map(i => {
        if (maquina) { return }
        if (maquinas[i].codigo != i) { return }

        maquina = maquinas[i]
    })
    return { maquina }
}

function ControlMapa() {
    let maquinaInfoToggle = false

    const iniciarComponents = () => {
        maquinaInfoToggle = false
        document.querySelectorAll("#lista-maquinas-mapa .maquinas").forEach(a => a.style.position = "absolute")
        document.querySelectorAll(".maquinas").forEach(a => {
            // document.getElementById("").addEventListener("mouseenter", maquinaHoverIn)
            a.addEventListener("mouseenter", maquinaHoverIn)
            a.addEventListener("mouseout", maquinaHoverOut)
        })
        window.addEventListener("click", hiddenMaquinaInfo)
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
            maquinaInfo.classList.toggle("active", maquinaInfoToggle)
        }, 1500)
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
    }

    const maquinaDragClickUpInventario = (ev) => {
        ev.preventDefault()
        const tag = document.getElementById("" + ev.dataTransfer.getData("text"))

        addMaquinaInventario(tag)
    }

    const addMaquinaMapa = (tag, x, y) => {
        if (x <= 0 || x >= mapa.clientWidth + tag.clientWidth || y <= 0 || y >= mapa.clientHeight + tag.clientHeight) {
            addMaquinaInventario(tag)
            return
        }
        tag.style.position = "absolute"

        updatePosition(tag, x, y)

        listaMCMapa.appendChild(tag)
        const { maquina } = getMaquina({ id: tag.id.substring(8) })

        maquina.posicionado = 1
        console.log(maquinas);
    }

    const addMaquinaInventario = (tag) => {
        tag.style.position = "relative"

        updatePosition(tag, 0, 0)

        listaMCInventario.appendChild(tag)
        const { maquina } = getMaquina({ id: tag.id.substring(8) })

        maquina.posicionado = 0
    }

    const updatePosition = (tag, x, y) => {
        const { maquina } = getMaquina({ id: tag.id.substring(8) })

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
