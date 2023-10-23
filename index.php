<?php
include 'config/global-config.php';
require_once 'util/index.php';
require_once 'src/index.php';
require_once 'src/services/render/render.client.php';

App::getInstance()->factory('public/pages', AppModule::getInstance());
