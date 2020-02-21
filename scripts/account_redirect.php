<?php
session_start();
if (isset($_SESSION["username"])){
    header("location: ../pages/logged_in_menu.php");
} else {
    header("location: ../pages/signup_login.php");
}
