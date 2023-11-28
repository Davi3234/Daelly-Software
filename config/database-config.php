<?php

global $DATABASE;

$provider = 'sqlite3'; // sqlite3 || mysql
$dbname = '';
$dbPath = '';
$user = '';
$pass = '';
$host = '';

if ($provider == 'mysql') {
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        $dbname = 'daelly';
        $user = 'root';
        $pass = 'root';
        $host = 'localhost';
    } else {
    }
} else if ($provider == 'sqlite3') {
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        $dbname = 'daelly';
        $dbPath = 'storage';
    } else {
    }
}

$DATABASE = [
    'provider' => $provider,
    'dbname' => $dbname,
    'dbPath' => $dbPath,
    'user' => $user,
    'pass' => $pass,
    'host' => $host,
];
