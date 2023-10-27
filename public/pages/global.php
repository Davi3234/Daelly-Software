<?php
require_once __DIR__ . '/../services/api/index.php';

function getRender($dir, $consoleState = false) {
    $render = RenderClient::createInstance($dir);

    if ($consoleState) {
        console($render->getState());
    }

    return $render;
}