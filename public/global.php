<?php
require_once 'services/api/index.php';

function getRender($dir, $consoleState = false) {
    $render = RenderClient::createInstance($dir);

    if ($consoleState) {
        console($render->getState());
    }

    return $render;
}