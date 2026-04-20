<?php
require_once '../config/database.php';

session_start();

$username = '';
$errors = [];

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
        // Get user from database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        $user = $stmt->fetch();

        if ($user) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                
                // Create session
                $_SESSION['user_id'] = $user['uid'];
                $_SESSION['username'] = $user['username'];

                // Redirect to dashboard
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