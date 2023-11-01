<?php

class Response
{
    private static $instance;
    private $notesDebugger;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        $this->notesDebugger = [];
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
        $this->notesDebugger[] = $note;
    }

    function send($data = [], $status = null)
    {
        if (isNumber($status)) {
            $this->status($status);
        }

        $data = json_decode(json_encode($data));

        if (isTruthy($this->notesDebugger)) {
            if (isArray($data)) {
                $data['notesDebugger'] = $this->notesDebugger;
            }
    
            if (isObject($data)) {
                $data->notesDebugger = $this->notesDebugger;
            }
        }

        echo json_encode($data);
    }
}
