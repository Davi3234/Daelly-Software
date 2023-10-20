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

    function loadIndexRouter() {
        if (is_file($this->basePath . '/index.php')) {
            include $this->basePath . '/index.php';
        }
    }

    function isValidInclude($dir, $target) {
        $path = str_replace($_SERVER["DOCUMENT_ROOT"] . "/", "", $dir) . "/" . $target;

        if (is_dir($path)) {
            return true;
        }

        if (is_file($path . ".php")) {
            return true;
        }

        return false;
    }

    function include($dir, $target = null) {
        if (!$target) {
            $this->includeNextRouter($dir);

            return;
        }

        if (!$this->isValidInclude($dir, $target)) {
            return;
        }

        $base = str_replace($_SERVER["DOCUMENT_ROOT"] . "/", "", $dir);

        $path = $base . "/" . $target;

        if (is_dir($path)) {
            include $path . "/index.php";
            return;
        }

        include $path . ".php";
    }

    function includeNextRouter($dir) {
        $path = substr($this->getPath(), 1);

        $base = str_replace($_SERVER["DOCUMENT_ROOT"] . "/", "", $dir);
        
        $fullPath = $base . "/" . explode("/", str_replace(str_replace($this->basePath, "", $base), "", $path))[0];

        echo "<br>" . $this->basePath;
        echo "<br>" . $base;
        echo "<br>" . $path;
        echo "<br>!" . str_replace($this->basePath, "", $base);
        echo "<br>!" . str_replace(str_replace($this->basePath . "/", "", $base), "", $path);
        echo "<br>" . $fullPath;

        if (is_dir($fullPath)) {
            include $fullPath . "/index.php";
        }
    }
}
