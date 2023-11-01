<?php
require_once 'common/util/index.php';
require_once 'config/global-config.php';
require_once 'common/services/session/index.php';
require_once 'common/services/router.php';
require_once 'common/services/url.php';
require_once 'common/services/uri.php';
require_once 'common/result.php';

Session::getInstance()->startSession();

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
        exit;
    }

    if ($_SERVER['HTTP_SEC_FETCH_DEST'] == Targets::Request->value) {
        require_once 'common/services/api/index.php';

        if ($_SERVER['PATH_INFO'] == '/api') {
            require_once 'src/index.php';
            exit;
        }
        if ($_SERVER['PATH_INFO'] == '/client') {
            require_once 'public/request.php';
            exit;
        }
    }

    if ($_SERVER['HTTP_SEC_FETCH_DEST'] == Targets::Style->value) {
        include remove_start_str($GLOBALS['GLOBAL_PREFIX_ROUTER'] . '/', remove_start_str('/', $_SERVER['REDIRECT_URL']));
        exit;
    }

    echo json_encode(['ok'=>true]);
}

bootstrap();