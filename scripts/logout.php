<?php
session_start();
session_unset();
session_destroy();
header("location: ../pages/info?success=logout");
exit;
