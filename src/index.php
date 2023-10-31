<?php
require_once 'common/guard.php';
require_once 'app/app.controller.php';
require_once 'services/jwt.php';
require_once 'services/api/index.php';

Response::getInstance()->startSend();

require_once 'services/database/index.php';
require_once 'app/app.controller.php';

$request = new Request();

$dataJson = file_get_contents('php://input');
$data = json_decode($dataJson, true);

$request->loadBody($data);
$request->loadParams($_REQUEST);
$request->loadHeaders($_SERVER);

Api::getInstance()->performHandler($request, Response::getInstance());