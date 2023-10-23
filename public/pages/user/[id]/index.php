<?php
$render = RenderClient::createInstance(__DIR__);

echo '<br>USER ' . $render->getQueryParam()['id'] . '<br>';
