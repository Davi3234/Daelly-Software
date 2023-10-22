<?php

include __DIR__ . '/../components/menu.php';

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
        echo '<br>PAGES<br>';

        Render::getInstance()->include(__DIR__);
        ?>
    </main>
</body>

</html>