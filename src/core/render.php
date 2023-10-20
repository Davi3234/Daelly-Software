<?php
require_once __DIR__ . "/../services/router.php";
require_once __DIR__ . "/../services/url.php";

class Render
{

    private static $instance;
    private $basePath;
    private $pathsRouters;

    private function __constructor()
    {
        $this->pathsRouters = [];
    }

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Render();
        }

        return self::$instance;
    }

    function initComponents($basePath)
    {
        $this->basePath = $basePath;

        $this->pathsRouters = Router::getInstance()->getRouters();
    }

    function performRedirect()
    {
        $path = $this->getPath();

        $this->renderFiles($path);
    }

    function getPath()
    {
        $routers = URL::getInstance()->getURLRoutersPaths();

        $path = $this->basePath;
        foreach ($routers as $router) {
            $path .= "/" . $router;
        }

        return $path;
    }

    function getPathsRouters()
    {
        return $this->pathsRouters;
    }

    function renderFiles($path)
    {
        if (!$this->validDirExists($path)) {
            return;
        }

        $basePath = "";

        $pathInArray = explode("/", $path);

        foreach ($pathInArray as $arg) {
            $basePath .= $arg . "/";

            if (!is_dir($basePath)) {
                if (is_file($basePath . "page-404.php")) {
                    include $basePath . "page-404.php";

                    return;
                }

                if (is_file($this->basePath . "/page-404.php")) {
                    include $this->basePath . "/page-404.php";
                } else {
                    echo "Not Found!";
                }

                return;
            }

            if (is_file($basePath . "index.php")) {
                include $basePath . "index.php";
            }
        }
    }

    function validDirExists($path)
    {
        $basePath = "";

        $pathInArray = explode("/", $path);

        foreach ($pathInArray as $arg) {
            $basePath .= $arg . "/";
        }

        return true;
    }
}
