<?php
require_once 'util/index.php';
require_once 'config/global-config.php';

$target = $_SERVER['HTTP_SEC_FETCH_DEST'];

enum Targets: string
{
    case Document = 'document';
    case Request = 'empty';
    case Style = 'style';
}

function performDocument()
{
    require_once 'src/index.php';
    require_once 'src/services/render/render.client.php';

    App::getInstance()->factory('public/pages', 'public/components');
}

function performRequest()
{
    require_once 'src/services/api/index.php';
    require_once 'src/services/database/index.php';
    require_once 'src/app/app.controller.php';

    $request = new Request();

    Response::getInstance()->startSend();

    $dataJson = file_get_contents("php://input");
    $data = json_decode($dataJson, true);

    $request->loadBody($data);
    $request->loadParams($_REQUEST);
    $request->loadHeaders($_SERVER);

    Api::getInstance()->performHandler($request, Response::getInstance());
}

function performStyle()
{
    include remove_start_str($GLOBALS['GLOBAL_PREFIX_ROUTER'] . '/', remove_start_str('/', $_SERVER['REDIRECT_URL']));
}

if ($_SERVER['HTTP_SEC_FETCH_DEST'] == 'document') {
    return performDocument();
}

if ($_SERVER['HTTP_SEC_FETCH_DEST'] == 'empty') {
    return performRequest();
}

if ($_SERVER['HTTP_SEC_FETCH_DEST'] == 'style') {
    return performStyle();
}
