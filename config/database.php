<?php
/*
 * database.php
 * Database connection configuration file
 * 
 * This file creates a reusable PDO connection to the MySQL database
 * It is included in pages that need to run SQL queries
 */

$host = 'localhost';
$dbname = 'project_db';
$dbUser= 'root';
$dbPass = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname; charset=utf8mb4",
        $dbUser,
        $dbPass
    );

    //Make PDO throw exceptions when there are errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Return Database results as associative arrays by default 
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>