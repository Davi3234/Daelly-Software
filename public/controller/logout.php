<?php
$token = $request->getBody('token');

Cookie::getInstance()->remove('token');

$response->send(Result::success(true)->getResult());