<?php

if ($request->getParam('router') == '/auth/sign-in/save') {
    require_once 'controller/save-session.php';
    return;
}

if ($request->getParam('router') == '/user/logout') {
    require_once 'controller/logout.php';
    return;
}
