<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

// Get projects that belong only to the logged-in user.
$stmt = $pdo->prepare("SELECT * FROM projects WHERE uid = ? ORDER BY start_date DESC, pid DESC");
$stmt->execute([$_SESSION['user_id']]);
$projects = $stmt->fetchAll();

include '../includes/header.php';
?>

<section class="page-head">
    <h1 class="title">Dashboard</h1>
    <p class="subtitle">
        Welcome <?php echo htmlspecialchars($_SESSION['username']); ?>.
        Here you can view and manage your own projects.
    </p>
</section>

<section class="card">
    <div class="actions">
        <a href="add_project.php" class="btn btn-primary">Add New Project</a>
    </div>
</section>

<section class="card">
    <h2>Your Projects</h2>

    <?php if (empty($projects)): ?>
        <p class="small">You have not added any projects yet.</p>
    <?php else: ?>
        <div class="projects">
            <?php foreach ($projects as $project): ?>
                <div class="project card">
                    <div class="project-body">
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p><strong>Start Date:</strong> <?php echo htmlspecialchars($project['start_date']); ?></p>
                        <p><strong>End Date:</strong> <?php echo htmlspecialchars($project['end_date'] ?? 'Not set'); ?></p>
                        <p><strong>Phase:</strong> <?php echo htmlspecialchars($project['phase']); ?></p>
                        <p><?php echo htmlspecialchars($project['short_description']); ?></p>

                        <div class="cta-row">
                            <a href="project.php?id=<?php echo $project['pid']; ?>" class="btn btn-secondary">View</a>
                            <a href="edit_project.php?id=<?php echo $project['pid']; ?>" class="btn btn-secondary">Edit</a>
                            <a href="delete_project.php?id=<?php echo $project['pid']; ?>" class="btn btn-secondary">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>