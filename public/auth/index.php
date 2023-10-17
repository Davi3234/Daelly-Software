<?php
function RenderPathsAuth() {
    $routerCount = count(explode("/", getPathFile(realpath(dirname(__FILE__))))) - 1;

    echo $routerCount;
}

RenderPathsAuth();