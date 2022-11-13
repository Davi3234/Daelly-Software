<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/GlobalStyles.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
<script src="/js/jquery-3.1.0.min.js"></script>
<script src="/js/jquery-maskedinput.min.js"></script>
<script>
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
    }
</script>