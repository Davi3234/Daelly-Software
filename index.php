<?php
include 'config/global-config.php';
require_once 'util/index.php';
require_once 'src/index.php';
require_once 'src/services/render/render.client.php';

App::getInstance()->factory('public/pages', AppModule::getInstance());

class Foo
{
    public function __construct() {}
    public function foo() {}
}

var_dump(
    is_callable(array('Foo', '__construct')),
    is_callable(array('Foo', 'foo'))
);