<?php

global $GLOBAL_PREFIX_ROUTER;

$GLOBAL_PREFIX_ROUTER = remove_end_str('/', remove_end_str('config', remove_start_str($_SERVER['DOCUMENT_ROOT'] . '/', str_replace('\\', '/', __DIR__))));
