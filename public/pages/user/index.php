<?php
$render = getRender(__DIR__);

echo '<br>USERS<br>';

if (!$render->include()) {
    echo $render->include('page-found');
}