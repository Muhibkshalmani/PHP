<?php
session_start();

// Security check: Only allow logged-in job seekers
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'seeker') {
    header("Location: login.php");
    exit;
}

$seeker_id = $_SESSION['user_id'];
$error = '';

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

    // Fetch applications made by this seeker
    $stmt = $pdo->prepare("SELECT applications.*, jobs.title AS job_title, jobs.location, jobs.salary, users.name AS employer_name 
                           FROM applications 
                           JOIN jobs ON applications.job_id = jobs.id 
                           JOIN users ON jobs.employer_id = users.id 
                           WHERE applications.seeker_id = ? 
                           ORDER BY applications.applied_at DESC");
    $stmt->execute([$seeker_id]);
    $my_applications = $stmt->fetchAll();

} catch (\PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seeker Dashboard - JobPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="homepage.php"><i class="fa-solid fa-briefcase text-primary me-2"></i>JobPortal <span class="badge bg-success fs-6 ms-2">Job Seeker</span></a>
            <div class="ms-auto d-flex align-items-center">
                <a href="homepage.php" class="btn btn-outline-light btn-sm me-3">Browse Jobs</a>
                <span class="text-white me-3">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">My Job Applications</h2>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <?php if (!empty($my_applications)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Salary</th>
                                    <th>Status</th>
                                    <th>Applied Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($my_applications as $app): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($app['job_title']) ?></td>
                                        <td><?= htmlspecialchars($app['employer_name']) ?></td>
                                        <td><?= htmlspecialchars($app['location']) ?></td>
                                        <td class="text-success"><?= htmlspecialchars($app['salary'] ?? 'N/A') ?></td>
                                        <td>
                                            <?php if ($app['status'] === 'Accepted'): ?>
                                                <span class="badge bg-success">Accepted</span>
                                            <?php elseif ($app['status'] === 'Rejected'): ?>
                                                <span class="badge bg-danger">Rejected</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($app['applied_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <p class="text-muted mb-3">You haven't applied to any jobs yet.</p>
                        <a href="homepage.php" class="btn btn-primary btn-sm">Explore Jobs Now</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>