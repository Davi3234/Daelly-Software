<?php
require_once "render.php";

class App {

    private static $instance;

    static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    function factory($publicBasePath) {
        Render::getInstance()->initComponents($publicBasePath);
        $this->redirect();
    }

    function redirect() {
        Render::getInstance()->performRedirect();
    }
}