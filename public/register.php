<?php
require_once '../config/database.php';

// Initialise variables for form values and messages.
$username = '';
$email = '';
$errors = [];
$success = '';

// Handle form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim user input to remove accidental spaces.
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Server-side validation.
    if ($username === '') {
        $errors[] = 'Username is required.';
    }

    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    if ($confirmPassword === '') {
        $errors[] = 'Please confirm your password.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    // If validation passes, check for duplicates and insert user.
    if (empty($errors)) {
        // Check whether username or email already exists.
        $stmt = $pdo->prepare("SELECT uid FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $errors[] = 'Username or email already exists.';
        } else {
            // Hash password before storing it.
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into database.
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashedPassword, $email]);

            $success = 'Registration successful. You can now log in.';

            // Clear form values after success.
            $username = '';
            $email = '';
        }
    }
}

include '../includes/header.php';
?>

<section class="page-head">
    <h1 class="title">Register</h1>
    <p class="subtitle">Create an account to add and manage your own software projects.</p>
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

    <?php if ($success !== ''): ?>
        <div class="card" style="border-color: rgba(80, 200, 120, 0.45);">
            <p><?php echo htmlspecialchars($success); ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php" class="form">
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
                <label for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    class="input"
                    type="email"
                    value="<?php echo htmlspecialchars($email); ?>"
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

        <div class="form-row">
            <div class="field">
                <label for="confirm_password">Confirm Password</label>
                <input
                    id="confirm_password"
                    name="confirm_password"
                    class="input"
                    type="password"
                    required
                >
            </div>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
    </form>
</section>

<?php include '../includes/footer.php'; ?>