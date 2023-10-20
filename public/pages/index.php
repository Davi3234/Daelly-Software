<?php

include __DIR__ . "/../components/menu.php";

echo "<br>PAGES<br>";

Render::getInstance()->include(__DIR__);

?>

<script>
    window.onload = () => {
        async function App() {
            const response = await API.post("src/index.php", {hello: "world"})

            console.log(response)
        }

        App()
    }
</script>