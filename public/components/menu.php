<?php
$routers = [
    "/" => "Home",
    "/user" => "User",
    "/user/create" => "User - Create",
    "/user/list" => "User - List",
    "/user/update" => "User - Update",
    "/auth" => "Auth",
    "/auth/sign-up" => "Auth - Sign-Up",
    "/auth/sign-in" => "Auth - Sign-In",
]
?>

<nav>
    <? foreach($routers as $router => $content) { if (!Render::getInstance()->existsRouter($router)) {continue;} ?>
        <a href="<?= $router ?>"><?= $content ?></a><br />
    <? } ?>
</nav>