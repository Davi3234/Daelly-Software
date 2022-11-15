window.onload = () => {
    document.querySelectorAll(".item-children.header").forEach(a => a.addEventListener("click", ({ target }) => {
        if (target.classList.contains("no-expansive")) { return }
        const tag = document.querySelector(".item-children.itens#i-expansive-" + (target.id.substr(2)))
        if (!tag) { return }
        tag.classList.toggle("active");
    }))

    document.querySelector(".close-alert") && document.querySelector(".close-alert").addEventListener("click", closeAlert)
    setTimeout(closeAlert, 1000 * 10)
}

function closeAlert() {
    document.querySelector(".alert") && document.querySelector(".alert").remove()
}
