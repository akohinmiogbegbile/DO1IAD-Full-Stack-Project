<?php
session_start();

// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';
?>

<section class="page-head">
    <h1 class="title">Dashboard</h1>
    <p class="subtitle">Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></p>
</section>

<section class="card">
    <p>You are now logged in.</p>
</section>

<?php include '../includes/footer.php'; ?>