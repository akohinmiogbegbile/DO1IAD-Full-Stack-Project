<?php
$pdo = new PDO("mysql:host=localhost;dbname=project_db", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$username = "david";

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "User found: " . $user['username'];
} else {
    echo "User not found";
}
?>