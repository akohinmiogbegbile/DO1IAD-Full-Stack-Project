<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$projectId = $_GET['id'] ?? '';

// Validate project ID.
if ($projectId === '' || !ctype_digit($projectId)) {
    die('Invalid project ID.');
}

// Fetch the project first.
$stmt = $pdo->prepare("SELECT * FROM projects WHERE pid = ?");
$stmt->execute([$projectId]);
$project = $stmt->fetch();

if (!$project) {
    die('Project not found.');
}

// Authorisation check: only owner can delete.
if ($project['uid'] != $_SESSION['user_id']) {
    die('You are not allowed to delete this project.');
}

// Delete the project.
$stmt = $pdo->prepare("DELETE FROM projects WHERE pid = ?");
$stmt->execute([$projectId]);

// Redirect back to dashboard.
header("Location: dashboard.php");
exit();
?>