<?php
/*
 *
 * This file protects pages that should only be accessible to authenticated users.
 * If no valid session exists, the user is redirected to the login page.
 */

 //start session if one has not already been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//redirect to login page if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>