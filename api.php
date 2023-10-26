<?php
include 'config/global-config.php';
require_once 'util/index.php';
require_once 'src/services/api/index.php';
require_once 'src/app/app.controller.php';

$request = new Request();

Response::getInstance()->startSend();

$dataJson = file_get_contents("php://input");
$data = json_decode($dataJson, true);

$request->loadBody($data);
$request->loadParams($_REQUEST);
$request->loadHeaders($_SERVER);

$responseData = Api::getInstance()->performHandler($request, Response::getInstance());

Response::getInstance()->send($responseData);
Response::getInstance()->endSend();
