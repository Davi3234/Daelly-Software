<?php

include __DIR__ . '/../components/menu.php';

function printObject($obj)
{
    foreach ($obj as $key => $value) {
        echo '"' . $key . '": "' . $value . '"';
        line();
    }
}

echo '<br>PAGES<br>';

printObject(Render::getInstance()->getNextRouter(__DIR__));
line();
line();
printObject(Render::getInstance()->getNextRouter(__DIR__ . '/user'));
line();
line();
printObject(Render::getInstance()->getNextRouter(__DIR__ . '/user/create'));

?>

<!-- <script>
    window.onload = () => {
        async function App() {
            const response = await API.post('src/index.php', {
                hello: 'world'
            })

            console.log(response)
        }

        // App()
    }
</script> -->