<?php
require_once 'src/services/api/index.php';

$response = Response::getInstance();
$request = Request::getInstance();

$dataJson = file_get_contents('php://input');
$data = json_decode($dataJson, true);

$response->startSend();
$request->loadBody($data);
$request->loadParams($_REQUEST);
$request->loadHeaders($_SERVER);
