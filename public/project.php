<?php
require_once '../config/database.php';

// Get project ID from URL.
$projectId = $_GET['id'] ?? '';

// Validate ID.
if ($projectId === '' || !ctype_digit($projectId)) {
    die('Invalid project ID.');
}

// Fetch project and owner email.
$stmt = $pdo->prepare("
    SELECT projects.*, users.email
    FROM projects
    JOIN users ON projects.uid = users.uid
    WHERE projects.pid = ?
");
$stmt->execute([$projectId]);

$project = $stmt->fetch();

include '../includes/header.php';
?>

<section class="page-head">
    <h1 class="title">Project Details</h1>
    <p class="subtitle">View the full details of this software project.</p>
</section>

<section class="card">
    <?php if (!$project): ?>
        <p>Project not found.</p>
    <?php else: ?>
        <h2><?php echo htmlspecialchars($project['title']); ?></h2>

        <p><strong>Start Date:</strong> <?php echo htmlspecialchars($project['start_date']); ?></p>
        <p><strong>End Date:</strong> <?php echo htmlspecialchars($project['end_date'] ?? 'Not set'); ?></p>
        <p><strong>Phase:</strong> <?php echo htmlspecialchars($project['phase']); ?></p>
        <p><strong>Owner Email:</strong> <?php echo htmlspecialchars($project['email']); ?></p>

        <div class="card" style="margin-top: 16px;">
            <h3>Short Description</h3>
            <p><?php echo nl2br(htmlspecialchars($project['short_description'])); ?></p>
        </div>

        <div class="cta-row" style="margin-top: 16px;">
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>