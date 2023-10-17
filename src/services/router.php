<?php

class Router {
    static function mergeRouters(array ...$arrays) {
        return array_merge(...$arrays);
    }

    static function getPathsRouter($path) {
        $paths = [];

        foreach (new DirectoryIterator($path) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                if ($fileInfo->isDir()) {
                    $paths[] = [$fileInfo->getFilename() => Router::getPathsRouter($fileInfo->getPathname())];
                }
            }
        }

        return $paths;
    }
}