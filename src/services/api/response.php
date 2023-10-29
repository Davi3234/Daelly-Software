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

    function startSend()
    {
        header('Content-Type: application/json; charset=UTF-8');
    }

    function status($status = 200)
    {
        http_response_code($status);

        return $this;
    }

    function send($data, $status = null)
    {
        if (isNumber($status)) {
            echo '!';
            $this->status($status);
        }

        echo json_encode($data);
    }
}
