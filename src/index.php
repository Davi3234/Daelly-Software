<?php

require_once __DIR__ . '/common/api/response.php';

if (isset($_POST)) {
    $data = file_get_contents("php://input");

    $res = json_decode($data, true) || [];

    if (isset($res["hello"])) {
        echo $res;
    }
    // return Response::getInstance()->send($res["hello"], 200);
}

echo "Not Hello";
// Response::getInstance()->send("Not Hello", 400);