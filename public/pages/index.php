<?php

include __DIR__ . "/../components/menu.php";

echo "<br>PAGES<br>";

Render::getInstance()->include(__DIR__);

if (Render::getInstance()->existsRouter("user")) {
    echo "!!!!";
} else {
    echo "????";
}