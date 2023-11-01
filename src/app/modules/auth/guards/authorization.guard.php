<?php
require_once __DIR__ . '/../auth.service.php';

class AuthorizationGuard implements Guard {
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function perform(Request $request, Response $response) {
        $res = AuthService::getInstance()->authorization(['Authorization' => $request->getHeader('HTTP_AUTHORIZATION')]);

        if (!$res->isSuccess()) {
            $response->send($res->getResult(), $res->getStatus());

            throw new UnauthorizedException($res->getResult()->error);
        }

        $request->setAttribute('userId', $res->getValue()['sub']);
    }
}