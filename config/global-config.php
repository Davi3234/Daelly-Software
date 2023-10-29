<?php

global $GLOBAL_PREFIX_ROUTER;

$filePath =  str_replace('\\', '/', __DIR__);
$documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$basePath = remove_start_str($documentRoot, $filePath);

$GLOBAL_PREFIX_ROUTER = remove_start_str('/', remove_end_str('/config', $basePath));
