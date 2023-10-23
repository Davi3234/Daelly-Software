<?php
$render = RenderClient::createInstance(__DIR__);

echo '<br>USERS<br>';

if (!$render->include()) {
    echo $render->include('page-found');
}