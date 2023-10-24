<?php
include 'config/global-config.php';
require_once 'util/index.php';
require_once 'src/index.php';
require_once 'src/services/api/index.php';

$request = new Request();

App::getInstance()->loadModule(AppModule::getInstance());
Response::getInstance()->startSend();

$dataJson = file_get_contents("php://input");
$data = json_decode( $dataJson, true );

$request->loadBody($data);
$request->loadParams($_REQUEST);
$request->loadHeaders($_SERVER);

Api::getInstance()->performHandler($request, Response::getInstance());

Response::getInstance()->status(200)->send(["hello" => 'Hello World']);
Response::getInstance()->endSend();