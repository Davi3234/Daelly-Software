<?php
$token = $request->getBody('token');
Session::getInstance()->setItem('token', $token);
$response->send(Result::success(true)->getResult());