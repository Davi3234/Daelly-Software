<?php
require_once 'components/utils.php';

function getRender($dir, $options = [])
{
    $render = RenderClient::createInstance($dir);

    if (isset($options['consoleState']) && isTruthy($options['consoleState'])) {
        console($render->getState());
    }
    if (!isset($options['not-load']) || isTruthy($options['not-load'])) {
        $render->loadState();
    }

    return $render;
}

function getRenderAnonymous()
{
    return getRender('', ['not-load' => true]);
}
