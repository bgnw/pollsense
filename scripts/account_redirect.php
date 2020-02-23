<?php
session_start();
if (isset($_SESSION["username"])){
    header("location: ../pages/user_options");
} else {
    header("location: ../pages/register_login");
}
