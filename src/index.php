<?php
require_once 'common/exception/index.php';
require_once 'common/guard.php';
require_once 'app/app.controller.php';
require_once 'services/jwt.php';
require_once 'services/database/index.php';
require_once 'app/app.controller.php';

try {
    Api::getInstance()->performHandler($request, $response);
} catch (Exception | ResultException $e) {
    if (!$e instanceof ResultException) {
        $response->send(Result::failure(ErrorModel::getInstance()->setMessage('Server internal error')->finally()), 500);
    }
}
