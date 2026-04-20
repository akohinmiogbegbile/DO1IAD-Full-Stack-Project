<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=pdops", "root", ""); # Connect me to my database
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>