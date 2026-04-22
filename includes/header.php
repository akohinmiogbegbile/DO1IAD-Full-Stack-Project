<?php
/*
 *
 * Shared page header and navigation.
 * The navigation changes depending on whether the user is logged in.
 */

 // Start session if one has not already been started. This helps to check if the user is logged in and to display the appropriate navigation links.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//To check if the user is authenticated. 
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Manager</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="mediaqueries.css">
</head>
<body>
    <header id="main-header" class="main-header">
        <nav class="nav">
            <a class="logo" href="index.php">Project Manager</a>

            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>

                <?php if ($isLoggedIn): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="add_project.php">Add Project</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>

            <div class="hamburger-menu">
                <div class="hamburger-icon" onclick="toggleMenu()">
                    <span></span><span></span><span></span>
                </div>
                <div class="menu-links">
                    <li><a href="index.php" onclick="toggleMenu()">Home</a></li>

                    <?php if ($isLoggedIn): ?>
                        <li><a href="dashboard.php" onclick="toggleMenu()">Dashboard</a></li>
                        <li><a href="add_project.php" onclick="toggleMenu()">Add Project</a></li>
                        <li><a href="logout.php" onclick="toggleMenu()">Logout</a></li>
                    <?php else: ?>
                        <li><a href="register.php" onclick="toggleMenu()">Register</a></li>
                        <li><a href="login.php" onclick="toggleMenu()">Login</a></li>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">