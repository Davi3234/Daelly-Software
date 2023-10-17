<?php

class Router {
    static function getRoutersParams($baseDir = "public") {
        $paths = [];

        foreach (new DirectoryIterator($baseDir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                if ($fileInfo->isDir()) {
                    $path = $baseDir . "/" . $fileInfo->getFilename();
                    $paths[] = $path;
                    $subPaths = Router::getRoutersParams($path);

                    foreach ($subPaths as $item) {
                        $paths[] = $item;
                    }
                }
            }
        }

        return $paths;
    }

    static function getRoutersParams($baseDir = "public") {
        $paths = [];

        foreach (new DirectoryIterator($baseDir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                if ($fileInfo->isDir()) {
                    $path = $baseDir . "/" . $fileInfo->getFilename();
                }
            }
        }

        return $paths;
    }
}