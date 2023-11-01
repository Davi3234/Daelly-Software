<?php
require_once 'global.php';
require_once 'common/services/render/render.client.php';

Render::getInstance()->initComponents('public/pages', 'public/components');
Render::getInstance()->loadRouter();
