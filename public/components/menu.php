<?php
$routers = [
    '/' => 'Home',
    '/user' => 'User',
    '/user/create' => 'User - Create',
    '/user/list' => 'User - List',
    '/user/update' => 'User - Update',
    '/user/1' => 'User - View',
    '/auth' => 'Auth',
    '/auth/sign-up' => 'Auth - Sign-Up',
    '/auth/sign-in' => 'Auth - Sign-In',
    '/not-found-test' => 'Not Found',
]
?>

<nav>
    <?php foreach ($routers as $router => $content) { ?>
        <a href='<?php echo URL::getInstance()->getURLRedirect($router) ?>'><?php echo $content ?></a><br />
    <?php } ?>
</nav>