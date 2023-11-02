<?php

if (!Cookie::getInstance()->get('token')) {
    if (!isStartsWith('/auth/sign-in', Render::getInstance()->getRouters())) {
?>
        <script>
            APP.url.redirect('/auth/sign-in')
        </script>
    <?php
        exit;
    }
} else {
    if (isStartsWith('/auth/sign-in', Render::getInstance()->getRouters())) {
    ?>
        <script>
            APP.url.redirect('/home')
        </script>
<?php
        exit;
    }
}
