<?php
require_once __DIR__ . '/../router.php';
require_once __DIR__ . '/../url.php';

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
        if ($_GET['url']) {
            return '/' . $_GET['url'];
        }

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
            echo 'Public static folder "' . $this->basePath . '" not found';
            exit(1);
        }
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
            return $this->includeNextParam($dir);
        }

        if (!$this->isValidInclude($dir, $target)) {
            return false;
        }

        $path = $this->getBaseFolder($dir) . '/' . $target;

        if (is_dir($path)) {
            include $path . '/' . 'index.php';
            return true;
        }

        if (is_file($path)) {
            include $path;
            return true;
        }

        if (is_file($path . '.php')) {
            include $path . '.php';
            return true;
        }

        return false;
    }

    function include($target)
    {
        if ($target) {
            if (str_starts_with($target, '/')) {
                $target = substr($target, 1);
            }
        }

        if (is_file($target)) {
            include $target;
            return true;
        }

        if (is_dir($target)) {
            if (is_file($target . '/' . 'index.php')) {
                include $target . '/' . 'index.php';
                return true;
            }

            return false;
        }

        if (is_file($target . '.php')) {
            include $target . '.php';
            return true;
        }

        return false;
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
            return false;
        }

        include $state['fullPath'] . '/' . 'index.php';

        return true;
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
        $STATE['queries'] = [];

        if ($this->isQueryParam(substr($STATE['pathCurrentFolder'], 1))) {
            $STATE['queries'][$this->getNextNameRouter(substr($STATE['pathCurrentFolder'], 1))] = $STATE['nextFolderPath'];
        }

        return $STATE;
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

    function validNextParam($state = [])
    {
        if (remove_string('/', $state['pathCurrentFolderWithoutRoot']) === $state['nextFolderPath']) {
            return false;
        }

        if ($state['pathCurrentFolderWithoutRoot']) {
            if (!$state['nextFolderPath']) {
                return false;
            }
        }

        return is_dir($state['fullPath']) || $this->isQueryParam(substr($state['pathCurrentFolder'], 1));
    }

    function getQueriesParams($dir)
    {
        $state = $this->getNextParam($dir);

        if (!$state['queries']) {
            return [];
        }

        return $state['queries'];
    }

    function isQueryParam($path)
    {
        $foldersNames = $this->getNamesNextQueryRouter($path);

        return !!count($foldersNames);
    }

    function getNextNameRouter($dir)
    {
        $foldersNames = $this->getNamesNextQueryRouter($dir);

        return $foldersNames[0];
    }

    function getNamesNextRouter($dir)
    {
        if (!is_dir($dir)) {
            return [];
        }

        $files = scandir($dir);

        $folders = [];

        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            if (is_file($dir . '/' . $file)) {
                continue;
            }

            if (!is_dir(($dir . '/' . $file))) {
                continue;
            }

            $folders[] = $file;
        }

        return $folders;
    }

    function getNamesNextQueryRouter($dir)
    {
        $foldersNames = $this->getNamesNextRouter($dir);

        $queryNames = [];

        foreach ($foldersNames as $name) {
            if (str_starts_with($name, '[') && str_ends_with($name, ']')) {
                $queryNames[] = substr($name, 1, strlen($name) - 2);
            }
        }

        return $queryNames;
    }
}
