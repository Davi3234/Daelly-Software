<?php

global $GLOBAL_PREFIX_ROUTER, $SECRET;

$filePath =  str_replace('\\', '/', __DIR__);
$documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$basePath = remove_start_str($documentRoot, $filePath);

$GLOBAL_PREFIX_ROUTER = remove_start_str('/', remove_end_str('/config', $basePath));
$SECRET = ['key' => 'jf98du89y87gvf87gg8787 &W&*F*&Y*&Y*&S*&DFS*D FEF# TG s', 'expire-token' => 86400 /* 24h in seconds */];
