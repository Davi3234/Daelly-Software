<?php
require_once 'scripts/index.php';
require_once 'global.php';
require_once 'common/services/render/render.client.php';
?>

<script>
    const GLOBAL_PREFIX_ROUTER = '<?= $GLOBALS['GLOBAL_PREFIX_ROUTER'] ?>'
</script>

<script src="<?= URL::getInstance()->createURLPath('/public/index.js') ?>"></script>

<?php
Render::getInstance()->initComponents([ 'public' => 'public/pages', 'component' => 'public/components', 'assets' => 'public/assets']);

getRenderAnonymous()->include('../services/valid-auth.php');

Render::getInstance()->loadRouter();
?>