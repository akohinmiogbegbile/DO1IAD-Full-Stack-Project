<?php
// Shared header for all public pages.
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
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>

            <div class="hamburger-menu">
                <div class="hamburger-icon" onclick="toggleMenu()">
                    <span></span><span></span><span></span>
                </div>
                <div class="menu-links">
                    <li><a href="index.php" onclick="toggleMenu()">Home</a></li>
                    <li><a href="register.php" onclick="toggleMenu()">Register</a></li>
                    <li><a href="login.php" onclick="toggleMenu()">Login</a></li>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">