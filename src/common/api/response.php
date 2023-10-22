<?php

class Response
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Response();
        }

        return self::$instance;
    }

    static function send($data = [], $status = 200)
    {
        http_response_code($status);
        echo json_encode($data);
    }
}
