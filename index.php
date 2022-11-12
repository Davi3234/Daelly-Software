<?php
session_start();
if (isset($_SESSION['email'])) {
    header("location: view/painel.php");
} else {
    header("location: view/login.php");
}
?>