const mapa = document.getElementById("lista-maquinas-mapa")
const mapaBox = document.getElementById("mapa-box")
const inventario = document.getElementById("lista-maquinas-inventario")
const maquinaInfo = document.getElementById("maquina-info-content")
const maquinaConfig = document.getElementById("maquina-config")

let validAddMaquinaMapa = true
let validShowDetailMaquina = true
const mapaDimension = { width: 1000, height: 1000, }

document.getElementById("mapa").style.width = mapaDimension.width + "px"
document.getElementById("mapa").style.height = mapaDimension.height + "px"

function ControlMapa() {
    const state = {
        mc: null,
        tag: null
    }

    const getMaquina = (codigo) => {
        let maquina = null

        Object.keys(maquinas).map(i => {
            if (maquina) { return }
            if (maquinas[i].codigo != codigo) { return }

            maquina = maquinas[i]
        })

        return {
            maquina
        }
    }

    const iniciarComponents = () => {
        document.getElementById("mapa-content").addEventListener("contextmenu", (ev) => {
            ev.preventDefault()
        })
        document.querySelectorAll(".maquinas").forEach(a => {
            a.addEventListener("mousedown", (ev) => {
                maquinaConfig.classList.toggle("active", false)
                if (ev.button == 0) maquinaClickDown(ev)
                else if (ev.button == 2) showOptionMaquina(ev)
            })
            a.addEventListener("mouseup", maquinaClickUp)
            a.addEventListener("mouseout", () => {
                maquinaInfo.classList.toggle("active", false)
                validShowDetailMaquina = false
            })
            a.addEventListener("mousemove", showDetailsMaquina)
        })
        document.querySelectorAll("#lista-maquinas-mapa .maquinas").forEach(a => {
            a.style.position = "absolute"
        })

        window.addEventListener("mousemove", ev => {
            if (!state.tag || !state.mc) { return }

            if (validAddMaquinaMapa) {
                addMaquinaMapa(state.tag, state.mc)
                validAddMaquinaMapa = false
            }

            mouseMove(ev)
        })
        window.addEventListener("click", () => {
            document.querySelector(".maquinas.active") && maquinaClickUp()
            maquinaConfig.classList.toggle("active", false)
        })

        maquinaConfig.addEventListener("click", (ev) => {
            addMaquinaInventario(document.getElementById("maquina-" + document.getElementById("mc-config-codigo").innerHTML))
        })
    }

    const showOptionMaquina = ({ srcElement: tag, pageX: x, pageY: y }) => {
        if (state.tag && state.mc) { return }
        const { maquina } = getMaquina(tag.id.substring(8))

        maquinaConfig.style.left = (x - tag.clientWidth) + "px"
        maquinaConfig.style.top = (y - tag.clientHeight) + "px"

        document.getElementById("mc-config-codigo").innerHTML = maquina.codigo

        maquinaConfig.classList.toggle("active", true)
        maquinaInfo.classList.toggle("active", false)
    }

    const showDetailsMaquina = ({ srcElement: tag, pageX: x, pageY: y }) => {
        if (state.tag && state.mc) { return }
        const { maquina } = getMaquina(tag.id.substring(8))

        maquinaInfo.style.left = x + "px"
        maquinaInfo.style.top = y + "px"

        document.getElementById("mc-info-codigo").innerHTML = maquina.codigo

        validShowDetailMaquina = true
        setTimeout(() => {
            if (!validShowDetailMaquina) { return }

            !maquinaConfig.classList.contains("active") && maquinaInfo.classList.toggle("active", true)
        }, 1000)
    }

    const addMaquinaMapa = (tag, mc) => {
        tag.style.position = "absolute"
        mapa.appendChild(tag)

        tag.style.left = mc.x + "px"
        tag.style.top = mc.y + "px"
    }

    const addMaquinaInventario = (tag) => {
        tag.style.position = "relative"
        tag.style.top = 0 + "px"
        tag.style.left = 0 + "px"
        inventario.appendChild(tag)
    }

    const maquinaClickDown = ({ target }) => {
        validShowDetailMaquina = false

        state.tag = target
        state.mc = getMaquina(target.innerHTML).maquina

        state.tag.classList.toggle("active", true)
        maquinaInfo.classList.toggle("active", false)
    }

    const maquinaClickUp = () => {
        if (!state.tag || !state.mc) { return }

        maquinaDrop()

        state.tag.classList.toggle("active", false)

        state.tag = null
        state.mc = null
    }

    const mouseMove = ({ clientX: x, clientY: y }) => {
        updateMoveTag(x - (state.tag.clientWidth / 2), y - (state.tag.clientHeight / 2))
    }

    const updateMoveTag = (x, y, tagA = null) => {
        const tag = tagA ? tagA : state.tag

        const bounds = tag.getBoundingClientRect()

        tag.style.left = x + "px"
        tag.style.top = y + "px"

        state.mc.x = x
        state.mc.y = y
    }

    const maquinaDrop = () => {
        validAddMaquinaMapa = true
        verifyCollision()
    }

    const verifyCollision = () => {
        const validCollision = (x1, y1, w1, h1, x2, y2, w2, h2) => {
            return ((x1 >= x2 && x1 <= x2 + w2 && y1 >= y2 && y1 <= y2 + h2) ||
                (x1 + w1 >= x2 && x1 + w1 <= x2 + w2 && y1 >= y2 && y1 <= y2 + h2) ||
                (x1 + w1 >= x2 && x1 + w1 <= x2 + w2 && y1 + h1 >= y2 && y1 + h1 <= y2 + h2) ||
                (x1 <= x2 + w2 && x1 >= x2 && y1 + h1 >= y2 && y1 + h1 <= y2 + h2))
        }

        const { mc, tag } = state

        Object.keys(maquinas).map(i => {
            const mc2 = maquinas[i]
            const tag2 = document.getElementById("maquina-" + mc2.codigo)

            if (mc.codigo == mc2.codigo) { return }

            if (validCollision(mc.x, mc.y, tag.clientWidth, tag.clientHeight, mc2.x, mc2.y, tag2.clientWidth, tag2.clientHeight)) {
                addMaquinaInventario(tag)
            }
        })
    }

    iniciarComponents()
}

window.onload = () => {
    ControlMapa()
}
