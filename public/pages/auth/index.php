<?php

echo '<br>AUTH<br>';

$render = RenderClient::createInstance(__DIR__);

console($render->getState());

$render->include();
