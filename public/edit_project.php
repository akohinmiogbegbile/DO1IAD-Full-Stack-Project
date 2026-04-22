<?php
/*
 *
 * This file allows an authenticated user to edit an existing project.
 * It retrieves the selected project, checks ownership, validates
 * updated form input, and saves the changes back to the database.
 */

 //Protect the page by ensuring only authenticated users can access it. If no valid session exists, the user will be redirected to the login page.
require_once '../includes/auth.php';
require_once '../config/database.php';

//Get the selected project ID from the URL 
$projectId = $_GET['id'] ?? '';
$errors = [];

// Validate project ID before using it in the query. 
if ($projectId === '' || !ctype_digit($projectId)) {
    die('Invalid project ID.');
}

// Fetch the project from the database using the provided ID. This will return the project record if a matching ID is found, or false if no match is found.
$stmt = $pdo->prepare("SELECT * FROM projects WHERE pid = ?");
$stmt->execute([$projectId]);
$project = $stmt->fetch();

if (!$project) {
    die('Project not found.');
}

// Authorisation check: only owner of the project (in this case the person who is logged in using the uid) can edit.
if ($project['uid'] != $_SESSION['user_id']) {
    die('You are not allowed to edit this project.');
}

// Load existing values into variables.
$title = $project['title'];
$startDate = $project['start_date'];
$endDate = $project['end_date'];
$shortDescription = $project['short_description'];
$phase = $project['phase'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';
    $shortDescription = trim($_POST['short_description'] ?? '');
    $phase = $_POST['phase'] ?? 'design';

    $allowedPhases = ['design', 'development', 'testing', 'deployment', 'complete'];

    // Server-side validation.
    if ($title === '') {
        $errors[] = 'Project title is required.';
    }

    if ($startDate === '') {
        $errors[] = 'Start date is required.';
    }

    if ($shortDescription === '') {
        $errors[] = 'Short description is required.';
    }

    if (!in_array($phase, $allowedPhases, true)) {
        $errors[] = 'Please choose a valid project phase.';
    }

    if ($endDate !== '' && $startDate !== '' && $endDate < $startDate) {
        $errors[] = 'End date cannot be earlier than start date.';
    }
// If validation passes, update the project in the database with the new values.
    if (empty($errors)) {
        $stmt = $pdo->prepare("
            UPDATE projects
            SET title = ?, start_date = ?, end_date = ?, short_description = ?, phase = ?
            WHERE pid = ?
        ");

        $stmt->execute([
            $title,
            $startDate,
            $endDate !== '' ? $endDate : null,
            $shortDescription,
            $phase,
            $projectId
        ]);

        header("Location: dashboard.php");
        exit();
    }
}

include '../includes/header.php';
?>

<section class="page-head">
    <h1 class="title">Edit Project</h1>
    <p class="subtitle">Update your project details below.</p>
</section>

<section class="card">
    <?php if (!empty($errors)): ?>
        <div class="card" style="border-color: rgba(255, 80, 80, 0.45);">
            <h3>There were some problems:</h3>
            <ul class="list">
                <?php foreach ($errors as $error): ?>
                    <li><p><?php echo htmlspecialchars($error); ?></p></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="edit_project.php?id=<?php echo htmlspecialchars($projectId); ?>" class="form">
        <div class="form-row">
            <div class="field">
                <label for="title">Project Title</label>
                <input
                    id="title"
                    name="title"
                    class="input"
                    type="text"
                    value="<?php echo htmlspecialchars($title); ?>"
                    required
                >
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <label for="start_date">Start Date</label>
                <input
                    id="start_date"
                    name="start_date"
                    class="input"
                    type="date"
                    value="<?php echo htmlspecialchars($startDate); ?>"
                    required
                >
            </div>

            <div class="field">
                <label for="end_date">End Date</label>
                <input
                    id="end_date"
                    name="end_date"
                    class="input"
                    type="date"
                    value="<?php echo htmlspecialchars($endDate); ?>"
                >
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <label for="phase">Project Phase</label>
                <select id="phase" name="phase" class="input" required>
                    <option value="design" <?php echo $phase === 'design' ? 'selected' : ''; ?>>Design</option>
                    <option value="development" <?php echo $phase === 'development' ? 'selected' : ''; ?>>Development</option>
                    <option value="testing" <?php echo $phase === 'testing' ? 'selected' : ''; ?>>Testing</option>
                    <option value="deployment" <?php echo $phase === 'deployment' ? 'selected' : ''; ?>>Deployment</option>
                    <option value="complete" <?php echo $phase === 'complete' ? 'selected' : ''; ?>>Complete</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <label for="short_description">Short Description</label>
                <textarea
                    id="short_description"
                    name="short_description"
                    class="input"
                    rows="5"
                    required
                ><?php echo htmlspecialchars($shortDescription); ?></textarea>
            </div>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Update Project</button>
        </div>
    </form>
</section>

<?php include '../includes/footer.php'; ?>