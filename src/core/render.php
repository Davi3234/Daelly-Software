<?php
require_once __DIR__ . '/../services/router.php';
require_once __DIR__ . '/../services/url.php';

class Render
{
    private static $instance;
    private $basePath;

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
    }

    function performRedirect()
    {
        $this->renderFiles();
    }

    function getBasePath()
    {
        return $this->basePath;
    }

    function getPath()
    {
        $routers = URL::getInstance()->getURLRoutersPaths();

        $path = '';

        if (count($routers) > 0) {
            foreach ($routers as $router) {
                if ($router) {
                    $path .= '/' . $router;
                }
            }
        }

        return $path;
    }

    function renderFiles()
    {
        $path = $this->getPath();

        $basePath = $this->basePath;

        $pathInArray = ["/"];

        if ($path) {
            $pathInArray = explode('/', $path);
        }

        foreach ($pathInArray as $key => $arg) {
            $basePath .= $arg . '/';

            $this->defineFilesToRouter($basePath, $arg);
        }
    }

    function defineFilesToRouter($base, $router)
    {
        if (is_file($base . 'layout.php')) {
            include $base . 'layout.php';

            return;
        }

        if (!is_dir($base)) {
            if (is_file($base . 'page-404.php')) {
                include $base . 'page-404.php';

                return;
            }

            if (is_file($this->basePath . '/page-404.php')) {
                include $this->basePath . '/page-404.php';
            } else {
                header(substr($base, -strlen($router . '/')));
            }

            return;
        }

        if (is_file($base . 'index.php')) {
            include $base . 'index.php';
        }
    }
}
