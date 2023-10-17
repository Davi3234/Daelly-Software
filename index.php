<?php
require_once "src/services/router.php";
require_once "src/services/url.php";

print_r(Router::getRoutersParams());
echo "<br>";
print_r(URL::getRouterArgsByIndex(0));
echo "<br>";
print_r(URL::getRouterArgsByIndex(1));
echo "<br>";
print_r(URL::getRouterArgsByIndex(2));