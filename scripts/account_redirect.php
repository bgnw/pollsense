<?php
session_start();
if (isset($_SESSION["username"])){
    echo "<script type=\"text/javascript\">document.location = \"../pages/logged_in_menu.php\";</script>";
} else {
    echo "<script type=\"text/javascript\">document.location = \"../pages/signup_login.php\";</script>";
}
