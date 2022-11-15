window.onload = () => {
    document.querySelectorAll(".item-children.header").forEach(a => a.addEventListener("click", ({
        target
    }) => {
        if (target.classList.contains("no-expansive")) {
            return
        }
        const tag = document.querySelector(".item-children.itens#i-expansive-" + (target.id.substr(2)))
        if (!tag) {
            return
        }
        tag.classList.toggle("active");
    }))

    document.querySelector(".close-alert").addEventListener("click", (ev) => {
        document.querySelector(".alert").remove()
    })
    setTimeout(() => {
        document.querySelector(".alert") && document.querySelector(".alert").remove()
    }, 1000 * 10)
}
