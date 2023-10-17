<?php

class Router {
    static function getRoutersParamsByIndex($index = 0, $baseDir = "public") {
        return array_keys(Router::getRoutersParams($baseDir)[$index])[$index];
    }

    static function getRoutersParams($baseDir = "public") {
        $paths = [];

        foreach (new DirectoryIterator($baseDir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                if ($fileInfo->isDir()) {
                    $paths[] = [$fileInfo->getFilename() => Router::getRoutersParams($fileInfo->getPathname())];
                }
            }
        }

        return $paths;
    }
}