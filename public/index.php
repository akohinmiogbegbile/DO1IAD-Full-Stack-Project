<?php
/*
 *
 * Public homepage of the application.
 * It displays all projects and allows visitors to search
 * by project title or start date.
 */
require_once '../config/database.php';

// read the search term from the URL using the GET method. If no search term is provided, it defaults to an empty string. 
// The trim function is used to remove any leading or trailing whitespace from the search term.
$search = trim($_GET['search'] ?? '');

// if a search term is provided, return only matching projects. If no search term is provided, return all projects. 
// The query uses a JOIN to also fetch the email of the project owner from the users table. The results are ordered by start date in descending order.
if ($search !== '') {
    $stmt = $pdo->prepare("
        SELECT projects.*, users.email
        FROM projects
        JOIN users ON projects.uid = users.uid
        WHERE projects.title LIKE ? OR projects.start_date LIKE ?
        ORDER BY projects.start_date DESC
    ");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("
        SELECT projects.*, users.email
        FROM projects
        JOIN users ON projects.uid = users.uid
        ORDER BY projects.start_date DESC
    ");
}

$projects = $stmt->fetchAll();

include '../includes/header.php';
?>

<section class="page-head">
    <h1 class="title">All Projects</h1>
    <p class="subtitle">Browse all available software projects.</p>
</section>

<section class="card">
    <form method="GET" action="index.php" class="form">
        <div class="form-row">
            <div class="field">
                <input
                    type="text"
                    name="search"
                    class="input"
                    placeholder="Search by title or start date..."
                    value="<?php echo htmlspecialchars($search); ?>"
                >
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
</section>

<section class="card">
    <h2><?php echo $search !== '' ? 'Search Results' : 'All Projects'; ?></h2>
    <?php if ($search !== ''): ?>
    <p class="small">Showing results for: <?php echo htmlspecialchars($search); ?></p>
<?php endif; ?>
    <?php if (empty($projects)): ?>
        <p>No projects found.</p>
    <?php else: ?>
        <div class="projects">
            <?php foreach ($projects as $project): ?>
                <div class="project card project-row">
    
    <div class="project-info">
        <h3><?php echo htmlspecialchars($project['title']); ?></h3>

        <p>
            <strong>Start Date:</strong> <?php echo htmlspecialchars($project['start_date']); ?>
            &nbsp;&nbsp;
            <strong>Phase:</strong> <?php echo htmlspecialchars($project['phase']); ?>
            &nbsp;&nbsp;
            <strong>Owner Email:</strong> <?php echo htmlspecialchars($project['email']); ?>
        </p>

        <p><?php echo htmlspecialchars($project['short_description']); ?></p>
    </div>

    <div class="project-actions">
        <a href="project.php?id=<?php echo $project['pid']; ?>" class="btn btn-secondary">
            View Details
        </a>
    </div>

</div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>