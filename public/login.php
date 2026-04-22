<?php
/*
 *
 * This file authenticates an existing user.
 * It validates input, checks the database for a matching username,
 * verifies the hashed password, creates a session, and redirects
 * the user to the dashboard after successful login.
 */

 //load the database connection
require_once '../config/database.php';

session_start();

//initialise form values and error storage
$username = '';
$errors = [];

//Handles the login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '') {
        $errors[] = 'Username is required.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        // Get users record from database by using the username provided in the form. This will return the user record if a matching username is found, or false if no match is found.
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        $user = $stmt->fetch();

        if ($user) {
            // Verify password and confirm it matches the stored hash in the database
            if (password_verify($password, $user['password'])) {
                
                // Create session by storing key user details in the session to keep the user logged in across pages. 
                // The session will be used to check if the user is authenticated and to identify the user on protected pages.
                $_SESSION['user_id'] = $user['uid'];
                $_SESSION['username'] = $user['username'];

                // Redirect the authenticated user to the dashboard
                header("Location: dashboard.php");
                exit();

            } else {
                $errors[] = 'Invalid username or password.';
            }
        } else {
            $errors[] = 'Invalid username or password.';
        }
    }
}

include '../includes/header.php';
?>

<section class="page-head">
    <h1 class="title">Login</h1>
    <p class="subtitle">Access your account to manage your projects.</p>
</section>

<section class="card">
    <?php if (!empty($errors)): ?>
        <div class="card" style="border-color: rgba(255, 80, 80, 0.45);">
            <ul class="list">
                <?php foreach ($errors as $error): ?>
                    <li><p><?php echo htmlspecialchars($error); ?></p></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="form">
        <div class="form-row">
            <div class="field">
                <label for="username">Username</label>
                <input
                    id="username"
                    name="username"
                    class="input"
                    type="text"
                    value="<?php echo htmlspecialchars($username); ?>"
                    required
                >
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <label for="password">Password</label>
                <input
                    id="password"
                    name="password"
                    class="input"
                    type="password"
                    required
                >
            </div>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
</section>

<?php include '../includes/footer.php'; ?>