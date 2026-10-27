<?php
session_start();

$job_id = $_GET['id'] ?? null;
if (!$job_id) {
    header("Location: homepage.php");
    exit;
}

$error = '';
$success = '';

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

    // Handle Job Application Submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply_job'])) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'seeker') {
            header("Location: login.php");
            exit;
        }

        $seeker_id = $_SESSION['user_id'];
        $cover_letter = trim($_POST['cover_letter']);

        // Handle Resume File Upload
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
            $allowed = ['pdf', 'doc', 'docx'];
            $filename = $_FILES['resume']['name'];
            $filetmp = $_FILES['resume']['tmp_name'];
            $fileext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($fileext, $allowed)) {
                $upload_dir = 'uploads/resumes/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $new_filename = uniqid('resume_', true) . '.' . $fileext;
                $destination = $upload_dir . $new_filename;

                if (move_uploaded_file($filetmp, $destination)) {
                    // Check if already applied
                    $stmt_check = $pdo->prepare("SELECT id FROM applications WHERE job_id = ? AND seeker_id = ?");
                    $stmt_check->execute([$job_id, $seeker_id]);
                    if ($stmt_check->rowCount() > 0) {
                        $error = "You have already applied for this job.";
                    } else {
                        $stmt_apply = $pdo->prepare("INSERT INTO applications (job_id, seeker_id, resume_path, cover_letter) VALUES (?, ?, ?, ?)");
                        if ($stmt_apply->execute([$job_id, $seeker_id, $destination, $cover_letter])) {
                            $success = "Your application was submitted successfully!";
                        } else {
                            $error = "Failed to submit application. Please try again.";
                        }
                    }
                } else {
                    $error = "Failed to upload resume file.";
                }
            } else {
                $error = "Invalid file type. Please upload a PDF, DOC, or DOCX file.";
            }
        } else {
            $error = "Please upload your resume.";
        }
    }

    // Fetch Job Details
    $stmt = $pdo->prepare("SELECT jobs.*, users.name AS employer_name, users.email AS employer_email, categories.name AS category_name 
                           FROM jobs 
                           JOIN users ON jobs.employer_id = users.id 
                           JOIN categories ON jobs.category_id = categories.id 
                           WHERE jobs.id = ?");
    $stmt->execute([$job_id]);
    $job = $stmt->fetch();

    if (!$job) {
        header("Location: homepage.php");
        exit;
    }

} catch (\PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><= htmlspecialchars($job['title']) ?> - JobPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="homepage.php"><i class="fa-solid fa-briefcase text-primary me-2"></i>JobPortal</a>
            <div class="ms-auto">
                <a href="homepage.php" class="btn btn-outline-light btn-sm">Back to Home</a>
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

        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Job Main Info -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 p-4 mb-4">
                    <span class="badge bg-secondary-subtle text-primary align-self-start mb-2"><?= htmlspecialchars($job['category_name']) ?></span>
                    <h1 class="fw-bold mb-3"><?= htmlspecialchars($job['title']) ?></h1>
                    
                    <div class="d-flex flex-wrap text-muted mb-4 gap-3">
                        <div><i class="fa-solid fa-building me-1 text-primary"></i> <?= htmlspecialchars($job['employer_name']) ?></div>
                        <div><i class="fa-solid fa-location-dot me-1 text-danger"></i> <?= htmlspecialchars($job['location']) ?></div>
                        <div><i class="fa-solid fa-money-bill-wave me-1 text-success"></i> <?= htmlspecialchars($job['salary'] ?? 'Competitive') ?></div>
                        <div><i class="fa-solid fa-clock me-1 text-secondary"></i> <?= htmlspecialchars($job['job_type']) ?></div>
                    </div>

                    <hr>

                    <h4 class="fw-bold mb-3">Job Description</h4>
                    <p class="text-secondary" style="white-space: pre-line;"><?= htmlspecialchars($job['description']) ?></p>
                </div>
            </div>

            <!-- Apply Card -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-4">
                    <h4 class="fw-bold mb-3">Apply for this Position</h4>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['user_role'] === 'seeker'): ?>
                            <form action="job_detail.php?id=<?= $job_id ?>" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Upload Resume (PDF / DOC)</label>
                                    <input type="file" class="form-control" name="resume" accept=".pdf,.doc,.docx" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cover Letter</label>
                                    <textarea class="form-control" name="cover_letter" rows="4" placeholder="Briefly explain why you are a great fit..."></textarea>
                                </div>
                                <button type="submit" name="apply_job" class="btn btn-primary w-100 py-2">Submit Application</button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-warning mb-0" role="alert">
                                You are logged in as an employer. Please log in with a **Job Seeker** account to apply for jobs.
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-muted">You must be logged in as a job seeker to apply for this job.</p>
                        <a href="login.php" class="btn btn-primary w-100 mb-2">Login to Apply</a>
                        <a href="register.php" class="btn btn-outline-secondary w-100">Register Account</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>