<?php 

class Response {
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Response();
        }

        return self::$instance;
    }

    static function status($status = 200) {
        http_response_code($status);
    }

    static function send($data = [], $status = 200) {
        self::status($status);
        echo json_encode($data);
    }
}