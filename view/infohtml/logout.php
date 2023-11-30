<?php
    require_once '../../control/ControlLogin.php';
    require_once '../../model/DaoLogin.php';
    require_once '../../model/Administrador.php';
    $control = new ControlLogin();
    session_start();
    $control->efetuarLogout();
    header("Location: login.php");                                      
?>
