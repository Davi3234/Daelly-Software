<?php
require_once 'scripts/index.php';
require_once 'global.php';
require_once 'common/services/render/render.client.php';
require_once 'common/services/render/render.client.php';

Render::getInstance()->initComponents('public/pages', 'public/components');
Render::getInstance()->loadRouter();
?>

<script src="<?= URL::getInstance()->createURLPath('/public/index.js') ?>"></script>