<?php
require_once "auth/routers.php";
require_once "../src/services/router.php";

class AppRouters {
    static $routers = Router::mergeRouters(AuthRouters::$routers, [
        "auth" => "auth"
    ]);
}