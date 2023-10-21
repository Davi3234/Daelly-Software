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
        $baseFolder = str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']);
        $baseRouterURL = URL::getInstance()->getBaseRouter();
        $baseRouterFolder = $this->basePath;
        $router = substr($this->getPath(), 1);

        if (!$router) {
            return;
        }

        $dirWithoutBaseFolder = str_replace($baseFolder, "", $dir); // "/Daelly-Software/public/pages"
        $pathCurrentFolder = str_replace("/" . $baseRouterURL, "", $dirWithoutBaseFolder); // "/public/pages"
        $pathCurrentFolderWithoutRoot = str_replace("/" . $baseRouterFolder, "", $pathCurrentFolder); // ""

        $restFolderPath = $router; // "user/create"

        if ($pathCurrentFolderWithoutRoot) {
            $restFolderPath = str_replace("/" . $pathCurrentFolderWithoutRoot, "", $router); // "user/create"
        }

        $nextFolderPath = explode("/", $restFolderPath)[0]; // ""

        var_dump($pathCurrentFolderWithoutRoot);
        line();
        var_dump($nextFolderPath);

        if (str_replace("/", "", $pathCurrentFolderWithoutRoot) === str_replace("/", "", $nextFolderPath)) {
            return;
        }

        $fullPath = substr($pathCurrentFolder, 1) . "/" . $nextFolderPath; // "public/pages/"

        var_dump($baseFolder);
        line();
        var_dump($baseRouterURL);
        line();
        var_dump($baseRouterFolder);
        line();
        var_dump($router);
        line();
        var_dump("--------");
        line();
        var_dump($dirWithoutBaseFolder);
        line();
        var_dump($pathCurrentFolder);
        line();
        var_dump($pathCurrentFolderWithoutRoot);
        line();
        var_dump($restFolderPath);
        line();
        var_dump($nextFolderPath);
        line();
        var_dump($fullPath);
        line();

        if (is_dir($fullPath)) {
            include $fullPath . '/' . 'index.php';
        }
    }
}

/*
# /
$dir = "C:/xampp/htdocs/Daelly-Software/public/pages";
$baseFolder = "C:/xampp/htdocs";
$baseRouterURL = "Daelly-Software";
$baseRouterFolder = "public/pages";
$router = "";

// return function, because $fullPath is equal $pathCurrentFolder => recursive load







# /user
$dir = "C:/xampp/htdocs/Daelly-Software/public/pages";
$baseFolder = "C:/xampp/htdocs";
$baseRouterURL = "Daelly-Software";
$baseRouterFolder = "public/pages";
$router = "user";

$dirWithoutBaseFolder = str_replace($baseFolder, "", $dir); // "/Daelly-Software/public/pages"
$pathCurrentFolder = str_replace("/" . $baseRouterURL, "", $dirWithoutBaseFolder); // "/public/pages"
$pathCurrentFolderWithoutRoot = str_replace("/" . $baseRouterFolder, "", $pathCurrentFolder); // ""
$restFolderPath = str_replace("/" . $pathCurrentFolderWithoutRoot, "", $router); // "user"

$restFolderPath = $router; // "user/create"

if ($pathCurrentFolderWithoutRoot) {
    $restFolderPath = str_replace("/" . $pathCurrentFolderWithoutRoot, "", $router); // "user/create"
}

$nextFolderPath = explode("/", $restFolderPath)[0]; // "user"

if (str_replace("/", "", $pathCurrentFolderWithoutRoot) === str_replace("/", "", $nextFolderPath)) {
    return;
}

$fullPath = substr($pathCurrentFolder, 1) . "/" . $nextFolderPath; // "public/pages/user"









# /user
$dir = "C:/xampp/htdocs/Daelly-Software/public/pages/user";
$baseFolder = "C:/xampp/htdocs";
$baseRouterURL = "Daelly-Software";
$baseRouterFolder = "public/pages";
$router = "user";

$dirWithoutBaseFolder = str_replace($baseFolder, "", $dir); // "/Daelly-Software/public/pages/user"
$pathCurrentFolder = str_replace("/" . $baseRouterURL, "", $dirWithoutBaseFolder); // "/public/pages/user"
$pathCurrentFolderWithoutRoot = str_replace("/" . $baseRouterFolder, "", $pathCurrentFolder); // "/user"
$restFolderPath = str_replace("/" . $pathCurrentFolderWithoutRoot, "", $router); // "user"

$restFolderPath = $router; // "user/create"

if ($pathCurrentFolderWithoutRoot) {
    $restFolderPath = str_replace("/" . $pathCurrentFolderWithoutRoot, "", $router); // "user/create"
}

$nextFolderPath = explode("/", $restFolderPath)[0]; // "user"

if (str_replace("/", "", $pathCurrentFolderWithoutRoot) === str_replace("/", "", $nextFolderPath)) {
    return;
}

$fullPath = substr($pathCurrentFolder, 1) . "/" . $nextFolderPath; // "public/pages/user"






# /
$dir = "C:/xampp/htdocs/Daelly-Software/public/pages";
$baseFolder = "C:/xampp/htdocs";
$baseRouterURL = "Daelly-Software";
$baseRouterFolder = "public/pages";
$router = "user/create";

$dirWithoutBaseFolder = str_replace($baseFolder, "", $dir); // "/Daelly-Software/public/pages"
$pathCurrentFolder = str_replace("/" . $baseRouterURL, "", $dirWithoutBaseFolder); // "/public/pages"
$pathCurrentFolderWithoutRoot = str_replace("/" . $baseRouterFolder, "", $pathCurrentFolder); // ""

$restFolderPath = $router; // "user/create"

if ($pathCurrentFolderWithoutRoot) {
    $restFolderPath = str_replace("/" . $pathCurrentFolderWithoutRoot, "", $router); // "user/create"
}

$nextFolderPath = explode("/", $restFolderPath)[0]; // "user"

if (str_replace("/", "", $pathCurrentFolderWithoutRoot) === str_replace("/", "", $nextFolderPath)) {
    return;
}

$fullPath = substr($pathCurrentFolder, 1) . "/" . $nextFolderPath; // "public/pages"
*/