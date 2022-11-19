window.onload = () => {
    $(".voltar").click(() => {
        window.history.back()
    })
    $(".item-children.header").click(({ target }) => {
        if (target.classList.contains("no-expansive")) { return }
        const tag = document.querySelector(".item-children.itens#i-expansive-" + (target.id.substr(2)))
        if (!tag) { return }
        if (!tag.classList.contains("active")) {
            document.querySelectorAll(".item-children.itens.active").forEach(a => { a.classList.toggle("active", false) })
        }
        tag.classList.toggle("active");
    })
    $(".close-alert").click(closeAlert)
    setTimeout(closeAlert, 1000 * 10)
}

function closeAlert() {
    document.querySelector(".alert") && document.querySelector(".alert").remove()
}
