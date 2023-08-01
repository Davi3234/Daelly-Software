const mapa = document.getElementById("mapa");
const listaMCMapa = document.getElementById("lista-maquinas-mapa");
const listaMCInventario = document.getElementById("lista-maquinas-inventario");
const maquinaInfo = document.getElementById("maquina-info-content");
const btSalvarMaquinas = document.getElementById("bt-salvar-maquinas");
const btResetarMaquinas = document.getElementById("bt-resetar-maquinas");
const btGuardarMaquinas = document.getElementById("bt-guardar-maquinas");

let maquinasAlteradas = [];
const maquinas = []; // Define the 'maquinas' array if it's not already defined.

// ... (Assuming 'maquinas' array is populated elsewhere)

function getMaquina({ codigo }) {
  const maquina = maquinas.find((maq) => maq.codigo === codigo);
  const tag = document.getElementById("maquina-" + codigo);
  return { maquina, tag };
}

function addMaquinaAtualizada({ id, codigo, posicionado, x, y }) {
  maquinasAlteradas.push({ id, codigo, posicionado, x, y });
}

function removerMaquinaAtualizada({ codigo }) {
  const index = maquinasAlteradas.findIndex((maq) => maq.codigo === codigo);
  if (index !== -1) {
    maquinasAlteradas.splice(index, 1);
  }
}

function atualizarListaMaquinasAlteradas(mcChanged) {
  const { maquina: mcOrigin } = getMaquina(mcChanged);
  const mcInUpdate = maquinasAlteradas.find((m) => m.codigo === mcChanged.codigo);

  if (!mcInUpdate) {
    if (mcChanged.posicionado !== mcOrigin.posicionado && mcOrigin.posicionado === 0) {
      addMaquinaAtualizada(mcChanged);
    }
    return;
  }

  if (mcChanged.posicionado === mcOrigin.posicionado) {
    if (mcOrigin.posicionado === 1) {
      if (mcChanged.x !== mcOrigin.x || mcChanged.y !== mcOrigin.y) {
        mcInUpdate.x = mcChanged.x;
        mcInUpdate.y = mcChanged.y;
        mcInUpdate.posicionado = 1;
      } else {
        removerMaquinaAtualizada(mcInUpdate);
      }
    } else {
      removerMaquinaAtualizada(mcInUpdate);
    }
  } else {
    if (mcChanged.posicionado === 1) {
      if (mcChanged.x !== mcOrigin.x || mcChanged.y !== mcOrigin.y) {
        mcInUpdate.x = mcChanged.x;
        mcInUpdate.y = mcChanged.y;
      } else {
        removerMaquinaAtualizada(mcInUpdate);
      }
    } else {
      mcInUpdate.posicionado = 0;
      mcInUpdate.x = 0;
      mcInUpdate.y = 0;
    }
  }
}

function ControlMapa() {
  let maquinaInfoToggle = false;

  const iniciarComponents = () => {
    maquinaInfoToggle = false;
    maquinaInfo.addEventListener("click", (ev) => {
      if (ev.target.classList.contains("close-info")) {
        hiddenMaquinaInfo();
      }
    });
    listaMCMapa.querySelectorAll(".maquinas").forEach((a) => (a.style.position = "absolute"));
    listaMCMapa.addEventListener("mouseout", (ev) => {
      if (!maquinaInfo.classList.contains("active")) {
        hiddenMaquinaInfo();
      }
    });
    listaMCMapa.addEventListener("click", (ev) => {
      if (ev.target.classList.contains("maquinas")) {
        showMaquinaInfo(ev.target);
      }
    });
    toggleBtActions();
  };

  // ... (Other functions remain unchanged)

  iniciarComponents();

  return {
    // ... (Other functions remain unchanged)
  };
}

let control = null;

window.onload = () => {
  control = ControlMapa();
};

function allowDrop(ev) {
  control && control.maquinaDragMove(ev);
}

function drag(ev) {
  control && control.maquinaDragClickDown(ev);
}

function dropMapa(ev) {
  control && control.maquinaDragClickUpMapa(ev);
}

function dropInventario(ev) {
  control && control.maquinaDragClickUpInventario(ev);
}

function resetarMaquinasAlteradas() {
  control && control.resetarMaquinas();
}

function guardarMaquinas() {
  control && control.guardarMaquinas();
}

function guardarMaquina() {
  control && control.guardarMaquina();
}
