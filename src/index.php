<?php
require_once 'common/exception/index.php';
require_once 'common/guard.php';
require_once 'app/app.controller.php';
require_once 'services/jwt.php';
require_once 'services/api/index.php';

$response = Response::getInstance();

$response->startSend();

require_once 'services/database/index.php';
require_once 'app/app.controller.php';

$request = Request::getInstance();

$dataJson = file_get_contents('php://input');
$data = json_decode($dataJson, true);

$request->loadBody($data);
$request->loadParams($_REQUEST);
$request->loadHeaders($_SERVER);

try {
    Api::getInstance()->performHandler($request, $response);
} catch(Exception | ResultException $e) {
    if (!$e instanceof ResultException) {
        $response->send(Result::failure(ErrorModel::getInstance()->setMessage('Server internal error')->finally()), 500);
    }
}