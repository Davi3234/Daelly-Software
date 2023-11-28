<?php

global $dbname, $user, $pass;

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $dbname = "daelly";
    $user = "root";
    $pass = "root";
} else {
    $dbname = "";
    $user = "";
    $pass = "";
}
