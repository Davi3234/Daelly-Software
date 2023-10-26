<?php

class ErrorResult {
    private $title;
    private $message;
    private $description;

    function __constructor($args) {

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
}