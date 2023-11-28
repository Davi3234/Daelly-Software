<?php
$token = $request->getBody('token');

Cookie::getInstance()->set('token', $token, 60 * 60 * 24);

$response->send(Result::success(true));