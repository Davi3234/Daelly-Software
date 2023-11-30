<?php
session_start();
require_once '../../control/ControlLogin.php';
require_once '../../model/Administrador.php';
require_once '../../model/DaoLogin.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$control = new ControlLogin();

if(!$control->executarLogin($email, $senha)){
    echo $control->getErr();
}
?>