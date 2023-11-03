<?php
require_once 'common/util/index.php';

function loadGlobalImports()
{
    require_once 'config/global-config.php';
    require_once 'common/services/session/index.php';
    require_once 'common/services/cookie/index.php';
    require_once 'common/services/router.php';
    require_once 'common/services/url.php';
    require_once 'common/services/uri.php';
    require_once 'common/exception/index.php';
    require_once 'common/result.php';

    Session::getInstance()->startSession();
}

enum Targets: string
{
    case Document = 'document';
    case Request = 'empty';
    case Style = 'style';
    case Script = 'script';
}

function bootstrap()
{
    $target = $_SERVER['HTTP_SEC_FETCH_DEST'];
    
    if ($target == Targets::Style->value || $target == Targets::Script->value) {
        loadGlobalImports();
        include remove_start_str($GLOBALS['GLOBAL_PREFIX_ROUTER'] . '/', remove_start_str('/', $_SERVER['REDIRECT_URL']));
        exit;
    }

    if ($target == Targets::Document->value) {
        loadGlobalImports();
        require_once 'public/index.php';
        exit;
    }

    if ($target == Targets::Request->value) {
        require_once 'prepare-request.php';

        $router = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : remove_start_str('/' . $GLOBALS['GLOBAL_PREFIX_ROUTER'], $_SERVER['REDIRECT_URL']);

        if ($router == '/api') {
            loadGlobalImports();
            require_once 'src/index.php';
            exit;
        }
        if ($router == '/client') {
            loadGlobalImports();
            require_once 'public/request.php';
            exit;
        }
    }

    echo json_encode(['ok' => false, 'status' => 404]);
}

bootstrap();
