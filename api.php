<?php
include 'config/global-config.php';
include 'src/app/modules/controllers.php';
require_once 'util/index.php';
require_once 'src/services/api/index.php';
require_once 'src/common/controller.php';

$request = new Request();

Response::getInstance()->startSend();

$dataJson = file_get_contents("php://input");
$data = json_decode($dataJson, true);

$request->loadBody($data);
$request->loadParams($_REQUEST);
$request->loadHeaders($_SERVER);

Api::getInstance()->performHandler($request, Response::getInstance());

Response::getInstance()->endSend();
