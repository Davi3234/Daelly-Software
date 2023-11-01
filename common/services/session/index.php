<?php

class Session
{
    private static $instance;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function getOrCreateItemIfNotExists($key, $value = null) {
        $this->startSession();

        if (!$this->getItem($key)) {
            $this->setItem($key, $value);
        }

        return $this->getItem($key);
    }

    function setItem($key, $value = null, $group = null) {
        $this->startSession();

        if (isset($group)) {
            return $this->setItemGroup($group, $key, $value);
        }

        $_SESSION[$key] = $value;
    }

    private function setItemGroup($group, $key, $value) {
        if (!isNull($this->getItem($group))) {
            $this->setGroup($group);
        }

        $_SESSION[$group][$key] = $value;
    }

    private function setGroup($key) {
        $_SESSION[$key] = [];
    }

    function removeItem($key, $group = null) {
        $this->startSession();

        if (isset($group)) {
            return $this->removeItemGroup($group, $key);
        }

        if (isNull($this->getItem($key))) {
            return;
        }

        unset($_SESSION[$key]);
    }

    private function removeItemGroup($group, $key) {
        if (isNull($this->getItem($group))) {
            return;
        }

        if (isNull($this->getItem($key, $group))) {
            return;
        }

        unset($_SESSION[$group][$key]);
    }

    function getItem($key, $group = null) {
        $this->startSession();

        if (isset($group)) {
            return $this->getItemGroup($group, $key);
        }

        if (!isset($_SESSION[$key])) {
            return null;
        }

        return $_SESSION[$key];
    }

    private function getItemGroup($group, $key) {
        if (!isNull($this->getItem($group))) {
            return null;
        }

        if (!isset($_SESSION[$group][$key])) {
            return null;
        }

        return $_SESSION[$group][$key];
    }

    function startSession() {
        if(!isset($_SESSION)) { 
            session_start(); 
        }
    }
}
