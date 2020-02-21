<?php
session_start();
if (isset($_SESSION["username"])){
    header("location: ../pages/logged_in_menu");
} else {
    header("location: ../pages/register_login");
}
