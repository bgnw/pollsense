<?php
if(!isset($_SESSION)) {session_start();}
/* Check if user is logged in.
    - If logged in, redirect to user options.
    - If not logged in, redirect to register/login page. */
if (isset($_SESSION["username"])) {
    header("location: ../pages/user_options");
} else {
    header("location: ../pages/register_login");
}
