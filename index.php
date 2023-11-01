<?php
function loadImports() {
    require_once 'common/util/index.php';
    require_once 'config/global-config.php';
    require_once 'common/services/session/index.php';
    require_once 'common/services/cookie/index.php';
    require_once 'common/services/router.php';
    require_once 'common/services/url.php';
    require_once 'common/services/uri.php';
    require_once 'common/result.php';

    Session::getInstance()->startSession();
}

enum Targets: string
{
    case Document = 'document';
    case Request = 'empty';
    case Style = 'style';
}

function bootstrap() {
    $target = $_SERVER['HTTP_SEC_FETCH_DEST'];

    if ($target == Targets::Document->value) {
        loadImports();
        require_once 'public/index.php';
        exit;
    }

    if ($target == Targets::Request->value) {
        require_once 'common/services/api/index.php';

        $router = $_SERVER['PATH_INFO'];

        if ($router == '/api') {
            loadImports();
            require_once 'src/index.php';
            exit;
        }
        if ($router == '/client') {
            loadImports();
            require_once 'public/request.php';
            exit;
        }
    }

    if ($target == Targets::Style->value) {
        loadImports();
        include remove_start_str($GLOBALS['GLOBAL_PREFIX_ROUTER'] . '/', remove_start_str('/', $_SERVER['REDIRECT_URL']));
        exit;
    }

    echo json_encode(['ok'=>true]);
}

bootstrap();