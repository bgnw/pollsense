<?php
// Delete all session data
if(!isset($_SESSION)) {session_start();}
session_unset();
session_destroy();
// Redirect to success message
header("location: ../pages/info?success=logout");
exit;
