<?php
session_start();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; // 'seeker' or 'employer'

    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Database Connection
        $host = 'localhost';
        $db   = 'job_portal';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $error = "This email is already registered. Please login instead.";
            } else {
                // Hash the password securely
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$name, $email, $hashed_password, $role])) {
                    $success = "Registration successful! You can now <a href='login.php'>Login here</a>.";
                } else {
                    $error = "Something went wrong. Please try again.";
                }
            }
        } catch (\PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - JobPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="homepage.php"><i class="fa-solid fa-briefcase text-primary me-2"></i>JobPortal</a>
            <div class="ms-auto">
                <a href="homepage.php" class="btn btn-outline-light btn-sm me-2">Home</a>
                <a href="login.php" class="btn btn-primary btn-sm">Login</a>
            </div>
        </div>
    </nav>

    <!-- Register Form Container -->
    <div class="container my-auto py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 p-4">
                    <h3 class="fw-bold mb-3 text-center">Create an Account</h3>
                    <p class="text-muted text-center mb-4">Join JobPortal to find jobs or hire talent.</p>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $success ?>
                        </div>
                    <?php endif; ?>

                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name / Company Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">I want to:</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="seeker">Find a Job (Job Seeker)</option>
                                <option value="employer">Post Jobs (Employer)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">Register</button>
                    </form>
                    <div class="text-center">
                        <p class="small text-muted mb-0">Already have an account? <a href="login.php" class="text-decoration-none">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3 mt-auto text-center">
        <p class="mb-0 small">&copy; 2026 JobPortal. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>