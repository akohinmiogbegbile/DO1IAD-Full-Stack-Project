<?php
session_start();

// Remove all session data and destroy the session.
$_SESSION = [];
session_destroy();

// Send user back to login page.
header("Location: login.php");
exit();
?>