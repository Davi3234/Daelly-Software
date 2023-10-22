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
        }
    }

    function isValidInclude($dir, $target = '')
    {
        $path = str_replace($_SERVER['DOCUMENT_ROOT'] . '/', '', $dir) . '/' . $target;

        if (is_dir($path)) {
            return true;
        }

        if (is_file($path . '.php')) {
            return true;
        }

        return false;
    }

    function existsRouter($router)
    {
        $router = str_replace('\\', '/', $router);

        return $this->isValidInclude($this->basePath, $router);
    }

    function include($dir, $target = null)
    {
        $dir = str_replace('\\', '/', $dir);

        if (!$target) {
            $this->includeNextRouter($dir);

            return;
        }

        if (!$this->isValidInclude($dir, $target)) {
            return;
        }

        $base = str_replace($_SERVER['DOCUMENT_ROOT'] . '/', '', $dir);

        $path = $base . '/' . $target;

        if (is_dir($path)) {
            include $path . '/' . 'index.php';
            return;
        }

        include $path . '.php';
    }

    function includeNextRouter($dir)
    {
        $state = $this->getNextRouter($dir);

        if (!$state['ok'] && !is_dir($state['fullPath'])) {
            return;
        }

        include $state['fullPath'] . '/' . 'index.php';
    }

    function getNextRouter($dir)
    {
        $STATE = [];

        $STATE['dir'] = str_replace('\\', '/', $dir);
        $STATE['baseFolder'] = str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']);
        $STATE['baseRouterURL'] = URL::getInstance()->getBaseRouter();
        $STATE['baseRouterFolder'] = $this->basePath;
        $STATE['router'] = substr($this->getPath(), 1);

        $STATE['dirWithoutBaseFolder'] = str_replace($STATE['baseFolder'], "", $STATE['dir']);
        $STATE['pathCurrentFolder'] = str_replace("/" . $STATE['baseRouterURL'], "", $STATE['dirWithoutBaseFolder']);
        $STATE['pathCurrentFolderWithoutRoot'] = str_replace("/" . $STATE['baseRouterFolder'], "", $STATE['pathCurrentFolder']);

        $STATE['restFolderPath'] = $STATE['router'];

        if ($STATE['pathCurrentFolderWithoutRoot']) {
            echo $STATE['pathCurrentFolderWithoutRoot'];
            line();
            echo $STATE['router'];
            line();
            line();

            $STATE['restFolderPath'] = str_replace("/" . $STATE['pathCurrentFolderWithoutRoot'], "", $STATE['router']);
        }

        $STATE['nextFolderPath'] = explode("/", $STATE['restFolderPath'])[0];

        $STATE['fullPath'] = substr($STATE['pathCurrentFolder'], 1) . ($STATE['nextFolderPath'] ? "/" . $STATE['nextFolderPath'] : "");
        $STATE['ok'] = $this->validNextRouter($STATE);

        return $STATE;
    }

    private function validNextRouter($state = [])
    {
        if (str_replace('/', '', $state['pathCurrentFolderWithoutRoot']) === $state['nextFolderPath']) {
            return false;
        }

        return is_dir($state['fullPath']);
    }
}

/*
# /

{
    dir: "C:/xampp/htdocs/Daelly-Software/public/pages",
    baseFolder: "C:/xampp/htdocs",
    baseRouterURL: "Daelly-Software",
    baseRouterFolder: "public/pages",
    router: "",
    dirWithoutBaseFolder: "/Daelly-Software/public/pages",
    pathCurrentFolder: "/public/pages",
    pathCurrentFolderWithoutRoot: "",
    restFolderPath: "",
    nextFolderPath: "",
    fullPath: "public/pages/"
},

$dir = "C:/xampp/htdocs/Daelly-Software/public/pages";
$baseFolder = "C:/xampp/htdocs;
$baseRouterURL = "Daelly-Software";
$baseRouterFolder = "public/pages";
$router = "";

$dirWithoutBaseFolder = str_replace($baseFolder, "", $dir); // "/Daelly-Software/public/pages"
$pathCurrentFolder = str_replace("/" . $baseRouterURL, "", $dirWithoutBaseFolder); // "/public/pages"
$pathCurrentFolderWithoutRoot = str_replace("/" . $baseRouterFolder, "", $pathCurrentFolder); // ""
$restFolderPath = str_replace("/" . $pathCurrentFolderWithoutRoot, "", $router); // ""

$restFolderPath = $router; // ""

if ($pathCurrentFolderWithoutRoot) {
    $restFolderPath = str_replace("/" . $pathCurrentFolderWithoutRoot, "", $router); // ""
}

$nextFolderPath = explode("/", $restFolderPath)[0]; // ""

$fullPath = substr($pathCurrentFolder, 1) . "/" . $nextFolderPath; // "public/pages/"




# /user

$dir = "C:/xampp/htdocs/Daelly-Software/public/pages";
$baseFolder = "C:/xampp/htdocs;
$baseRouterURL = "Daelly-Software";
$baseRouterFolder = "public/pages";
$router = "user";

$dirWithoutBaseFolder = str_replace($baseFolder, "", $dir); // "/Daelly-Software/public/pages"
$pathCurrentFolder = str_replace("/" . $baseRouterURL, "", $dirWithoutBaseFolder); // "/public/pages"
$pathCurrentFolderWithoutRoot = str_replace("/" . $baseRouterFolder, "", $pathCurrentFolder); // ""
$restFolderPath = str_replace("/" . $pathCurrentFolderWithoutRoot, "", $router); // "user"

$restFolderPath = $router; // "user"

if ($pathCurrentFolderWithoutRoot) {
    $restFolderPath = str_replace("/" . $pathCurrentFolderWithoutRoot, "", $router); // ""
}

$nextFolderPath = explode("/", $restFolderPath)[0]; // "user"

$fullPath = substr($pathCurrentFolder, 1) . "/" . $nextFolderPath; // "public/pages/user"
*/