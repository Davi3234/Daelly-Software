<?php

require_once "src/services/url.php";
require_once "src/services/navigation.php";

// var_dump($_GET);

echo filter_input(INPUT_GET, "url", FILTER_DEFAULT);
?>