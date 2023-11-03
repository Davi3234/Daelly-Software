<?php
require_once 'common/guard.php';
require_once 'app/app.controller.php';
require_once 'services/jwt.php';
require_once 'services/database/index.php';
require_once 'app/app.controller.php';

try {
    Api::getInstance()->performHandler($request, $response);
    exit;
} catch (Exception | ResultException $e) {
    if (!$e instanceof ResultException) {
        $err = new ErrorModel();
        $response->send(Result::failure($err->setMessage('Server internal error')->getError()), 500);
        exit;
    }

    $err = new ErrorModel($e->getError());
    $response->send(Result::failure($err->getError()), $err->getStatus());
    exit;
}
