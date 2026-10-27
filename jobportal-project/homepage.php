<?php
session_start(); // Must be at the very top before any HTML output

// Database Connection Configuration
$host = 'localhost';
$db   = 'job_portal';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch Latest 4 Job Listings from Database
$stmt = $pdo->query("SELECT jobs.*, users.name AS employer_name, categories.name AS category_name 
                     FROM jobs 
                     JOIN users ON jobs.employer_id = users.id 
                     JOIN categories ON jobs.category_id = categories.id 
                     ORDER BY jobs.created_at DESC LIMIT 4");
$latest_jobs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobPortal - Find Your Dream Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
        }
        .job-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="homepage.php"><i class="fa-solid fa-briefcase text-primary me-2"></i>JobPortal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="homepage.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jobs">Browse Jobs</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php 
                            $dashboard_page = 'seeker_dashboard.php';
                            if ($_SESSION['user_role'] === 'employer') {
                                $dashboard_page = 'employer_dashboard.php';
                            } elseif ($_SESSION['user_role'] === 'admin') {
                                $dashboard_page = 'admin_dashboard.php';
                            }
                        ?>
                        <li class="nav-item ms-lg-3">
                            <a class="nav-link text-warning fw-semibold" href="<?= $dashboard_page ?>">
                                <i class="fa-solid fa-user-circle me-1"></i> Dashboard (<?= htmlspecialchars($_SESSION['user_name']) ?>)
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-outline-danger btn-sm px-3 mb-2 mb-lg-0" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3"><a class="btn btn-outline-light btn-sm px-3 mb-2 mb-lg-0" href="login.php">Login</a></li>
                        <li class="nav-item ms-lg-2"><a class="btn btn-primary btn-sm px-3" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Find Your Dream Job Today</h1>
            <p class="lead mb-4">Explore thousands of job openings or connect with top-tier global employers.</p>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose JobPortal?</h2>
                <p class="text-muted">We make hiring and job hunting simple, transparent, and fast.</p>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm h-100">
                        <div class="text-primary fs-1 mb-3"><i class="fa-solid fa-shield-check"></i></div>
                        <h4 class="h5 fw-bold">Verified Companies</h4>
                        <p class="text-muted mb-0">All employers are vetted to ensure safe, legitimate employment opportunities.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm h-100">
                        <div class="text-primary fs-1 mb-3"><i class="fa-solid fa-bolt"></i></div>
                        <h4 class="h5 fw-bold">Instant Applications</h4>
                        <p class="text-muted mb-0">Apply with your uploaded resume in just one click and track application status live.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm h-100">
                        <div class="text-primary fs-1 mb-3"><i class="fa-solid fa-headset"></i></div>
                        <h4 class="h5 fw-bold">24/7 Support</h4>
                        <p class="text-muted mb-0">Our dedicated support team is here to guide you through your career steps.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dynamic Jobs Section -->
    <section id="jobs" class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Latest Job Openings</h2>
                <a href="jobs.php" class="text-decoration-none fw-semibold">View All Jobs &rarr;</a>
            </div>

            <div class="row g-4">
                <?php if (!empty($latest_jobs)): ?>
                    <?php foreach ($latest_jobs as $job): ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="card job-card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-secondary-subtle text-primary align-self-start mb-2"><?= htmlspecialchars($job['category_name']) ?></span>
                                    <h5 class="card-title fw-bold text-dark"><?= htmlspecialchars($job['title']) ?></h5>
                                    <p class="text-muted small mb-2"><i class="fa-solid fa-building me-1"></i> <?= htmlspecialchars($job['employer_name']) ?></p>
                                    <p class="text-muted small mb-3"><i class="fa-solid fa-location-dot me-1"></i> <?= htmlspecialchars($job['location']) ?></p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="fw-bold text-success small"><?= htmlspecialchars($job['salary'] ?? 'Competitive') ?></span>
                                            <span class="badge bg-light text-dark border"><?= htmlspecialchars($job['job_type']) ?></span>
                                        </div>
                                        <a href="job_detail.php?id=<?= $job['id'] ?>" class="btn btn-outline-primary w-100 btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">No job openings available right now. Check back soon!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 JobPortal. Built with PHP & MySQL. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>