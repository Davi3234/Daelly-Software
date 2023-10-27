<?php
require_once __DIR__ . '/../services/api/index.php';

function getRender($dir, $consoleState = false) {
    $render = RenderClient::createInstance($dir);

    if ($consoleState) {
        console($render->getState());
    }

    return $render;
}

$render = getRender(__DIR__);

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #fff;
        }

        body {
            width: 100vw;
            height: 100vh;
            background-color: #2a2a2a;
        }
    </style>
</head>

<body>
    <main>
        <?php
        $render->include('../components/menu');

        echo '<br>PAGES<br>';

        $render->include();

        if ($render->isPageNotFound()) {
            $render->include('page-404');
        }
        ?>

        <script>
            async function App() {
                const response = await API.post('/users/create', {
                    hello: 'world'
                })

                console.log(response)
            }

            App()
        </script>
    </main>
</body>

</html>