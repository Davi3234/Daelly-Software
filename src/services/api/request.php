<?php

class Request
{
    private static $instance;
    private $body;
    private $params;
    private $headers;
    private $attributes;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->attributes = [];
        $this->initComponents();
    }

    private function initComponents()
    {
        $this->loadParams();
        $this->loadHeaders();
    }

    function loadBody($body)
    {
        $this->body = $body;
    }

    function loadParams($params = [])
    {
        $this->params = $params;
    }

    function loadHeaders($headers = [])
    {
        $this->headers = $headers;
    }

    function getParams()
    {
        return $this->params;
    }

    function getParam($name)
    {
        if (isset($this->getParams()[$name])) {
            return $this->getParams()[$name];
        }

        return '';
    }

    function getHeaders()
    {
        return $this->headers;
    }

    function getHeader($name)
    {
        if (isset($this->getHeaders()[$name])) {
            return $this->getHeaders()[$name];
        }

        return '';
    }

    function getAllBody()
    {
        return $this->body;
    }

    function getBody($name)
    {
        if (isset($this->getAllBody()[$name])) {
            return $this->getAllBody()[$name];
        }

        return '';
    }

    function getAttributes() {
        return $this->attributes;
    }

    function getAttribute($name) {
        if (isset($this->getAttributes()[$name])) {
            return $this->getAttributes()[$name];
        }

        return null;
    }

    function setAttribute($name, $value) {
        $this->attributes[$name] = $value;
    }
}
