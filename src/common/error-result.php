<?php

class ErrorModel {
    private $title;
    private $message;
    private $description;
    private $stack;

    private function __constructor() {
        $this->title = '';
        $this->message = '';
        $this->description = '';
        $this->stack = '';
    }

    static function getInstance() {
        return new ErrorModel();
    }

    function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    function setMessage($message) {
        $this->message = $message;

        return $this;
    }
    
    function setDescription($description) {
        $this->description = $description;

        return $this;
    }
    
    function setStack($stack) {
        $this->stack = $stack;

        return $this;
    }

    function finally() {
        return new ErrorResult($this->title, $this->message, $this->description, $this->stack);
    }
}

class ErrorResult {
    private $title;
    private $message;
    private $description;
    private $stack;

    function __constructor($title = null, $message = null, $description = null, $stack = null) {
        $this->title = $title;
        $this->message = $message;
        $this->description = $description;
        $this->stack = $stack;
    }

    function getTitle() {
        return $this->title;
    }
    function getMessage() {
        return $this->message;
    }
    function getDescription() {
        return $this->description;
    }
    function getStack() {
        return $this->stack;
    }
}