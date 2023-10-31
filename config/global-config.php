<?php

global $GLOBAL_PREFIX_ROUTER, $KEY_SECRET;

$filePath =  str_replace('\\', '/', __DIR__);
$documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$basePath = remove_start_str($documentRoot, $filePath);

$GLOBAL_PREFIX_ROUTER = remove_start_str('/', remove_end_str('/config', $basePath));
$KEY_SECRET = 'jf98du89y87gvf87gg8787 &W&*F*&Y*&Y*&S*&DFS*D FEF# TG s';
