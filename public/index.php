<?php
function RenderPaths() {
    $path = URL::getRouterArgs()[0];

    if (!isset($path) || $path == "/" || $path == "/home") {
        return;
    }

    if ($path == "auth") {
        include "auth/index.php";
    }
}

RenderPaths();