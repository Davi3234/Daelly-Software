<?php

class Render
{
    private static $instance;
    private $STATE;

    static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        $this->STATE = [
            'publicBasePath' => '',
            'componentBasePath' => '',
            'assetsBasePath' => ''
        ];
    }

    function initComponents($state = [])
    {
        $this->STATE['publicBasePath'] = isset($state['public']) ? $state['public'] : '';
        $this->STATE['componentBasePath'] = isset($state['component']) ? $state['component'] : '';
        $this->STATE['assetsBasePath'] = isset($state['assets']) ? $state['assets'] : '';
    }

    function loadRouter()
    {
        if (is_file($this->STATE['publicBasePath'] . '/' . 'index.php')) {
            include $this->STATE['publicBasePath'] . '/' . 'index.php';
        } else {
            die('Public static folder "' . $this->STATE['publicBasePath'] . '" not found');
        }
    }

    function isPageNotFound()
    {
        return !$this->existsRouter($this->STATE['publicBasePath'] . URL::getInstance()->getURLRouters());
    }

    function existsRouter($router)
    {
        $router = str_replace('\\', '/', $router);

        $existsRouter = $this->validInclude($router);

        return $existsRouter;
    }

    function includeComponent($target)
    {
        $target = $this->STATE['componentBasePath'] ? $this->STATE['componentBasePath'] . '/' . remove_start_str('/', $target) : remove_start_str('/', $target);

        return $this->include($target);
    }

    function includeAsset($target)
    {
        $target = $this->STATE['assetsBasePath'] ? $this->STATE['assetsBasePath'] . '/' . remove_start_str('/', $target) : remove_start_str('/', $target);

        return $this->include($target);
    }

    function include($target = '')
    {
        if (!$this->validInclude($target)) {
            return false;
        }

        if ($target) {
            $target = remove_start_str('/', $target);
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

    function validInclude($target)
    {
        if ($target) {
            $target = remove_start_str('/', $target);
        }

        if (is_file($target)) {
            return true;
        }

        if (is_dir($target)) {
            if (is_file($target . '/' . 'index.php')) {
                return true;
            }

            return false;
        }

        if (is_file($target . '.php')) {
            return true;
        }

        if ($this->isQueryParamNextRouter($target)) {
            return true;
        }

        return false;
    }

    function isQueryParamNextRouter($path)
    {
        $path = remove_start_str('/', remove_start_str($this->STATE['publicBasePath'], $path));

        $currentPathRouter = $this->STATE['publicBasePath'];

        foreach (explode('/', $path) as $key => $value) {
            $pathRouter = $currentPathRouter . '/' . $value;

            if (!is_dir($pathRouter) && !is_file($pathRouter . '.php')) {
                $isQuery = false;

                foreach ($this->getNamesNextRouterFolder($currentPathRouter) as $keyFolder => $valueFolder) {
                    if ($this->isQueryParam($valueFolder)) {
                        $isQuery = true;
                    }
                }

                if (!$isQuery) {
                    return false;
                }
            }

            $currentPathRouter = $pathRouter;
        }

        return true;
    }

    function hasQueryParamNextRouter($path)
    {
        $foldersNames = $this->getNamesNextQueryRouter($path);

        return !!count($foldersNames);
    }

    function hasQueryParam()
    {
        $params = $this->getQueryParam();

        return !!count($params);
    }

    function getQueryParam()
    {
        $routers = explode('/', remove_start_str('/', URL::getInstance()->getURLRouters()));
        $structureFolders = $this->getAllNamesRouter();

        $queries = [];

        $currentPath = '';
        foreach ($routers as $key => $value) {
            if (!is_array($value)) {
                if (isset($structureFolders[$value])) {
                    $structureFolders = $structureFolders[$value];
                } else {
                    foreach ($structureFolders as $keyS => $valueS) {
                        if ($this->isQueryParam($keyS)) {
                            if (!isset($queries[substr($keyS, 1, -1)])) {
                                $queries[substr($keyS, 1, -1)] = $value;
                            }
                        }
                    }
                }
            }
        }

        return $queries;
    }

    function isQueryParam($nameFolder = '')
    {
        return isStartsWith('[', $nameFolder) && isEndsWith(']', $nameFolder);
    }

    function getNextNameRouter($dir)
    {
        $foldersNames = $this->getNamesNextQueryRouter($dir);

        return $foldersNames[0];
    }

    function getNamesNextQueryRouter($dir)
    {
        $foldersNames = $this->getNamesNextRouterFolder($dir);

        $queryNames = [];

        foreach ($foldersNames as $name) {
            if (isStartsWith('[', $name) && isEndsWith(']', $name)) {
                $queryNames[] = substr($name, 1, strlen($name) - 2);
            }
        }

        return $queryNames;
    }

    function getAllNamesRouter($dir = '')
    {
        if (!$dir) {
            $dir = $this->STATE['publicBasePath'];
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

            $folders[$file] = $this->getAllNamesRouter($dir . '/' . $file);
        }

        return $folders;
    }

    function getNamesNextRouterFolder($dir)
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

    function getPublicBasePath()
    {
        return $this->STATE['publicBasePath'];
    }

    function getBaseFolder($dir)
    {
        $baseFolder = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
        $baseRouterURL = URL::getInstance()->getBaseRouter();

        $publicBasePath  = remove_string('/' . $baseRouterURL . '/', str_replace($baseFolder, '', $dir));

        return $publicBasePath;
    }
}
