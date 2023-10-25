<?php

global $CONTROLLERS;

function getPathController($name) {
    $BASE = __DIR__;

    return $BASE . '/' . $name . '/' . $name . '.controller.php';
}

$CONTROLLERS = [
    'users' => getPathController('user')
];