<?php

function getPathFile($realpath) {
    $path = $_SERVER['SCRIPT_FILENAME'];
    $path_parts = pathinfo($path);
    
    return str_replace($path_parts['dirname'] . "/", "", $realpath);
}