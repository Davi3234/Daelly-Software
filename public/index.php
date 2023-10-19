<?php

$routers = [
    "auth" => "auth/index.php",
    "user" => "user/index.php",
];

echo Router::getRouter(0);

if (array_key_exists(Router::getRouter(0), $routers)) {

}

