<?php
$response = Response::getInstance();
$response->startSend();
$request = Request::getInstance();

$dataJson = file_get_contents('php://input');
$data = json_decode($dataJson, true);

$request->loadBody($data);
$request->loadParams($_REQUEST);
$request->loadHeaders($_SERVER);

if ($request->getParam('router') == '/auth/sign-in/save') {
    require_once 'controller/save-session.php';
    return;
}

if ($request->getParam('router') == '/admin/logout') {
    require_once 'controller/logout.php';
    return;
}