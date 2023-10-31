<?php
require_once 'util/index.php';
require_once 'config/global-config.php';
require_once 'src/services/session/index.php';
require_once 'src/services/router.php';
require_once 'src/services/url.php';
require_once 'src/services/uri.php';
require_once 'src/common/result.php';

$target = $_SERVER['HTTP_SEC_FETCH_DEST'];

enum Targets: string
{
    case Document = 'document';
    case Request = 'empty';
    case Style = 'style';
}

function bootstrap() {
    if ($_SERVER['HTTP_SEC_FETCH_DEST'] == Targets::Document->value) {
        require_once 'public/index.php';
        return;
    }

    if ($_SERVER['HTTP_SEC_FETCH_DEST'] == Targets::Request->value) {
        require_once 'src/index.php';
        return;
    }

    if ($_SERVER['HTTP_SEC_FETCH_DEST'] == Targets::Style->value) {
        include remove_start_str($GLOBALS['GLOBAL_PREFIX_ROUTER'] . '/', remove_start_str('/', $_SERVER['REDIRECT_URL']));
        return;
    }
}

bootstrap();