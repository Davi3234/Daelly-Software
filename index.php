<?php
include 'config/global-config.php';
require_once 'src/util/index.php';
require_once 'src/common/module.php';
require_once 'src/common/controller.php';
require_once 'src/app/index.php';
require_once 'src/core/app.php';

App::getInstance()->factory('public/pages', AppModule::getInstance());
