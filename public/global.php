<?php
require_once 'services/api/index.php';
require_once 'components/utils.php';

function getRender($dir, $consoleState = false)
{
    $render = RenderClient::createInstance($dir);

    if ($consoleState) {
        console($render->getState());
    }

    return $render;
}

?>

<script>
    class URL {
        static GLOBAL_PREFIX_ROUTER = '<?= $GLOBALS['GLOBAL_PREFIX_ROUTER'] ?>'

        static changeUrl(url = '') {
            if (!url.startsWith('/')) {
                url = `/${url}`
            }

            const baseUrl = URL.GLOBAL_PREFIX_ROUTER ? `/${URL.GLOBAL_PREFIX_ROUTER}${url}` : url

            window.history.pushState({}, '', baseUrl)
        }
    }
</script>