<?php
// Delete all session data
session_start();
session_unset();
session_destroy();
// Redirect to success message
header("location: ../pages/info?success=logout");
exit;
