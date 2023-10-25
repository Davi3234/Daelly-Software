<?php
require_once __DIR__ . '/../services/api/index.php';

$render = RenderClient::createInstance(__DIR__);

console($render->getState());
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
                const response = await fetch('api.php', {
                    method: 'POST'
                }).then(res => res.text()).then(res => res).catch(err => err)

                console.log(response)
            }

            // App()
        </script>
    </main>
</body>

</html>