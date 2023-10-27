<?php
$render = getRender(__DIR__);

echo '<br>USER ' . $render->getQueryParam()['id'] . '<br>';
