$(document).ready(function() {
    $('.carregando').fadeOut();
    $('.conteudo').fadeIn();
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
    $(".item-children.header").hover(({ target }) => {
        if (target.classList.contains("no-expansive")) { return }
        const tagI = document.querySelector(".item-children.itens#i-expansive-" + (target.id.substr(2)))
        if (!tagI) { return }
        tagI.classList.toggle("show", true);
        const tagH = document.querySelector(".item-children.header#i-" + (target.id.substr(2)))
        if (!tagH) { return }
        tagH.classList.toggle("show", true);
    }, ({ target }) => {
        document.querySelectorAll(".item-children.itens.show").forEach(a => { a.classList.toggle("show", false) })
    })
    $(".close-alert").click(closeAlert)
    $("#i-menu").click(() => {
        $("#barra-lateral").toggleClass("active")
    })
    $("#filter-table").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table-results tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
})

function closeAlert() {
    document.querySelector(".alert") && document.querySelector(".alert").remove()
}
