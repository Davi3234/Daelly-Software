<?php
session_start();
if (isset($_SESSION['email'])) {
    header("location: painel.php");
} else {
    header("location: login.php");
}
?>