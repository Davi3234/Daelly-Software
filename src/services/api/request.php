<?php

class Request {
    private $body;
    private $params;
    private $headers;

    function __constructor() {
        $this->initComponents();
    }

    private function initComponents() {
        $this->loadParams();
        $this->loadHeaders();
    }

    function loadBody($body) {
        $this->body = $body;
    }

    function loadParams($params = []) {
        $this->params = $params;
    }

    function loadHeaders($headers = []) {
        $this->headers = $headers;
    }

    function getParams() {
        return $_REQUEST;
    }

    function getParam($name) {
        if (isset($this->getParams()[$name])) {
            return $this->getParams()[$name];
        }

        return '';
    }

    function getHeaders() {
        return getallheaders();
    }

    function getHeader($name) {
        if (isset($this->getHeaders()[$name])) {
            return $this->getHeaders()[$name];
        }

        return '';
    }

    function getAllBody() {
        return $this->body;
    }

    function getBody($name) {
        if (isset($this->getAllBody()[$name])) {
            return $this->getAllBody()[$name];
        }

        return '';
    }
}