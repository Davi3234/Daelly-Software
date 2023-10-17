<?php
function RenderPaths() {
    $path = URL::getRoutersParams()[0];

    if (!isset($path) || $path == "/" || $path == "/home") {
        return;
    }

    if ($path == "auth") {
        include "auth/index.php";
    }
}

RenderPaths();