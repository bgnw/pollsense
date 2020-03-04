<?php
session_start();
session_unset();
session_destroy();
if (isset($_GET["redirect"])){
    header("location: ../pages/info?success=logout");
} else {
    echo "Logout successful.";
}
