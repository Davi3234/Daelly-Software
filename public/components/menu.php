<?php

$routers = [
    'User - Create' => '/user/create'
];

foreach ($routers as $key => $value) {
    ?>
    <a href="<?= URL::getInstance()->createURLPath($value) ?>"><?= $key ?></a>
    <?php
}

line();
line();