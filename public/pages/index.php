<?php
$render = getRender(__DIR__);
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Document</title>
    <link rel="stylesheet" href="<?= URL::getInstance()->createURLPath('/public/pages/style.css') ?>">
</head>

<body>
    <main>
        <?php
        $render->include();

        if (!Render::getInstance()->getRouters()) {
            $render->include('home');
        ?>
            <script>
                APP.url.changeUrl('/home')
            </script>
        <?php
        }
        ?>
    </main>
</body>

</html>