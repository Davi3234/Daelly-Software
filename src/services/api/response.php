<?php

class Response
{
    private static $instance;
    private $notes;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        $this->notes = [];
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

    function addNote($note) {
        $this->notes[] = $note;
    }

    function send($data, $status = null)
    {
        if (isNumber($status)) {
            $this->status($status);
        }

        if (isArray($data)) {
            $data[] = $this->notes;
        }

        if (isObject($data)) {
            $data = (object) $data;

            $data->notes = $this->notes;
        }

        echo json_encode($data);
    }
}
