<?php

class Router {
    private static $instance;

    static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new Router();
        }

        return self::$instance;
    }

    function getRouter($index = 0) {
        return $this->getRouterArgsByIndex($index);
    }

    function getNextRouters($baseDir = "public") {
        $paths = [];

        foreach (new DirectoryIterator($baseDir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                if ($fileInfo->isDir()) {
                    $path = $fileInfo->getFilename();

                    $paths[] = $path;
                }
            }
        }

        return $paths;
    }

    function getRouters($baseDir = "public") {
        $paths = [];

        foreach (new DirectoryIterator($baseDir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                if ($fileInfo->isDir()) {
                    $path = $fileInfo->getFilename();

                    $paths[$path] = $this->getRouters($baseDir."/".$path);
                }
            }
        }

        return $paths;
    }
}