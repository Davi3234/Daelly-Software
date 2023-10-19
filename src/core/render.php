<?php
require_once __DIR__ . "/../services/router.php";
require_once __DIR__ . "/../services/url.php";

class Render {

    private static $instance;
    private $basePath;
    private $pathsRouters;

    private function __constructor() {
        $this->pathsRouters = [];
    }

    static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new Render();
        }

        return self::$instance;
    }

    function initComponents($basePath) {
        $this->basePath = $basePath;

        $this->pathsRouters = Router::getInstance()->getRouters();
    }

    function performRedirect() {
        $router = substr(URL::getInstance()->getURLRouters(), 1);

        $router;
    }

    function getPathsRouters() {
        return $this->pathsRouters;
    }
}