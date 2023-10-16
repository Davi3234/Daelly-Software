<?php

require_once "src/services/router.php";

$words = Router::getRouterArgs();

echo Router::getRouterURL() . "<br>";

foreach ($words as $currentWord) {
    echo $currentWord . "<br>";
}

// $url = $_GET['url'] ?? '/';

// $routes = [
//     '/' => 'public/index.php',
//     '/about' => 'about.php',
//     '/contact' => 'contact.php',
//     '/auth/sign-in' => '/public/auth/sign-in.php',
// ];

// if (array_key_exists($url, $routes)) {
//     // include $routes[$url];
// } else {
//     include 'public/page-404.php';
// }