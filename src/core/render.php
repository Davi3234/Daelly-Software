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

    function loadIndexRouter()
    {
        if (is_file($this->basePath . '/' . 'index.php')) {
            include $this->basePath . '/' . 'index.php';
        } else {
            echo '"' . $this->basePath . '" not contain "index.php" file';
            exit(1);
        }
    }

    function isValidInclude($dir, $target = '')
    {
        $path  = $this->getBaseFolder($dir) . '/' . $target;

        if (is_dir($path)) {
            return true;
        }

        if (is_file($path) || is_file($path . '.php')) {
            return true;
        }

        return false;
    }

    function existsRouter($router)
    {
        $router = str_replace('\\', '/', $router);

        return $this->isValidInclude($this->basePath, $router);
    }

    function isPageNotFound()
    {
        $router = substr($this->getPath(), 1);

        return !$this->existsRouter($router);
    }

    function isPageNotFoundNext($dir)
    {
        $state = $this->getNextParam($dir);

        return $state['ok'];
    }

    function includeNext($dir, $target = null)
    {
        $dir = str_replace('\\', '/', $dir);

        if (!$target) {
            $this->includeNextParam($dir);

            return;
        }

        if (!$this->isValidInclude($dir, $target)) {
            return;
        }

        $path = $this->getBaseFolder($dir) . '/' . $target;

        if (is_dir($path)) {
            include $path . '/' . 'index.php';
            return;
        }

        if (is_file($path)) {
            include $path;
            return;
        }

        if (is_file($path . '.php')) {
            include $path . '.php';
        }
    }


    function include($target)
    {
        $base = $this->basePath . '/..';

        $path = $this->getBaseFolder($base) . '/' . $target;

        if (is_dir($path)) {
            include $path . '/' . 'index.php';
            return;
        }

        if (is_file($path)) {
            include $path;
            return;
        }

        if (is_file($path . '.php')) {
            include $path . '.php';
        }
    }

    function getBaseFolder($dir)
    {
        $baseFolder = str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']);
        $baseRouterURL = URL::getInstance()->getBaseRouter();

        $basePath  = remove_string('/' . $baseRouterURL . '/', str_replace($baseFolder, "", $dir));

        return $basePath;
    }

    function includeNextParam($dir)
    {
        $state = $this->getNextParam($dir);

        if (!$state['ok'] || !is_dir($state['fullPath'])) {
            return;
        }

        include $state['fullPath'] . '/' . 'index.php';
    }

    function getNextParam($dir)
    {
        $STATE = [];

        $STATE['dir'] = str_replace('\\', '/', $dir);
        $STATE['baseFolder'] = str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']);
        $STATE['baseRouterURL'] = URL::getInstance()->getBaseRouter();
        $STATE['baseRouterFolder'] = $this->basePath;
        $STATE['router'] = substr($this->getPath(), 1);

        $STATE['dirWithoutBaseFolder'] = remove_string($STATE['baseFolder'], $STATE['dir']);
        $STATE['pathCurrentFolder'] = remove_string("/" . $STATE['baseRouterURL'], $STATE['dirWithoutBaseFolder']);
        $STATE['pathCurrentFolderWithoutRoot'] = remove_string("/" . $STATE['baseRouterFolder'], $STATE['pathCurrentFolder']);

        $STATE['restFolderPath'] = $STATE['router'];

        if ($STATE['pathCurrentFolderWithoutRoot']) {
            $pathCurrentFolderWithoutRootAndStarBar = substr($STATE['pathCurrentFolderWithoutRoot'], 1);

            $STATE['restFolderPath'] = remove_string($pathCurrentFolderWithoutRootAndStarBar, $STATE['router']);

            if (substr($STATE['restFolderPath'], 0, 1) == "/") {
                $STATE['restFolderPath'] = substr($STATE['restFolderPath'], 1);
            }
        }

        $STATE['nextFolderPath'] = explode("/", $STATE['restFolderPath'])[0];

        $STATE['fullPath'] = substr($STATE['pathCurrentFolder'], 1) . ($STATE['nextFolderPath'] ? "/" . $STATE['nextFolderPath'] : "");
        $STATE['ok'] = $this->validNextParam($STATE);

        return $STATE;
    }

    private function validNextParam($state = [])
    {
        if (remove_string('/', $state['pathCurrentFolderWithoutRoot']) === $state['nextFolderPath']) {
            return false;
        }

        if ($state['pathCurrentFolderWithoutRoot']) {
            if (!$state['nextFolderPath']) {
                return false;
            }
        }

        return is_dir($state['fullPath']);
    }
}
