<?php

global $provider, $dbname, $user, $pass, $host;

$provider = 'sqlite3'; // sqlite3 || mysql

if ($provider == 'mysql') {
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        $dbname = "daelly";
        $user = "root";
        $pass = "root";
        $host = 'localhost';
    } else {
        $dbname = "";
        $user = "";
        $pass = "";
        $host = '';
    }
} else if ($provider == 'sqlite3') {
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        $dbname = "daelly";
    } else {
        $dbname = "";
    }
}
