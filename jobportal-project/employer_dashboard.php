<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'employer') {
    header("Location: login.php");
    exit;
}

$employer_id = $_SESSION['user_id'];
$success = '';
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

    // Handle Job Deletion
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $stmt_del = $pdo->prepare("DELETE FROM jobs WHERE id = ? AND employer_id = ?");
        if ($stmt_del->execute([$delete_id, $employer_id])) {
            $success = "Job deleted successfully!";
        } else {
            $error = "Failed to delete job.";
        }
    }

    // Handle Application Status Update (Accept / Reject)
    if (isset($_GET['app_action']) && isset($_GET['app_id'])) {
        $app_action = $_GET['app_action'];
        $app_id = $_GET['app_id'];
        
        $new_status = ($app_action === 'accept') ? 'Accepted' : (($app_action === 'reject') ? 'Rejected' : null);
        
        if ($new_status) {
            // Security check: Ensure the application belongs to a job posted by this employer
            $stmt_check = $pdo->prepare("SELECT applications.id FROM applications 
                                         JOIN jobs ON applications.job_id = jobs.id 
                                         WHERE applications.id = ? AND jobs.employer_id = ?");
            $stmt_check->execute([$app_id, $employer_id]);
            if ($stmt_check->rowCount() > 0) {
                $stmt_update = $pdo->prepare("UPDATE applications SET status = ? WHERE id = ?");
                if ($stmt_update->execute([$new_status, $app_id])) {
                    $success = "Application status updated to {$new_status} successfully!";
                } else {
                    $error = "Failed to update application status.";
                }
            }
        }
    }

    // Handle New Job Submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_job'])) {
        $title = trim($_POST['title']);
        $category_id = $_POST['category_id'];
        $location = trim($_POST['location']);
        $salary = trim($_POST['salary']);
        $job_type = $_POST['job_type'];
        $description = trim($_POST['description']);

        if (empty($title) || empty($category_id) || empty($location) || empty($description)) {
            $error = "Please fill in all required fields.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO jobs (employer_id, title, description, category_id, location, salary, job_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$employer_id, $title, $description, $category_id, $location, $salary, $job_type])) {
                $success = "Job posted successfully!";
            } else {
                $error = "Failed to post job. Please try again.";
            }
        }
    }

    // Fetch Categories
    $categories = $pdo->query("SELECT * FROM categories")->fetchAll();

    // Fetch Jobs Posted by this Employer
    $stmt = $pdo->prepare("SELECT jobs.*, categories.name AS category_name FROM jobs JOIN categories ON jobs.category_id = categories.id WHERE jobs.employer_id = ? ORDER BY jobs.created_at DESC");
    $stmt->execute([$employer_id]);
    $my_jobs = $stmt->fetchAll();

    // Fetch Applications received
    $stmt_apps = $pdo->prepare("SELECT applications.*, jobs.title AS job_title, users.name AS seeker_name, users.email AS seeker_email 
                                FROM applications 
                                JOIN jobs ON applications.job_id = jobs.id 
                                JOIN users ON applications.seeker_id = users.id 
                                WHERE jobs.employer_id = ? 
                                ORDER BY applications.applied_at DESC");
    $stmt_apps->execute([$employer_id]);
    $applications = $stmt_apps->fetchAll();

} catch (\PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard - JobPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="homepage.php"><i class="fa-solid fa-briefcase text-primary me-2"></i>JobPortal <span class="badge bg-primary fs-6 ms-2">Employer</span></a>
            <div class="ms-auto d-flex align-items-center">
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

        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Employer Dashboard</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postJobModal"><i class="fa-solid fa-plus me-1"></i> Post New Job</button>
        </div>

        <!-- My Job Postings Section -->
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold">My Job Postings</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($my_jobs)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Salary</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($my_jobs as $job): ?>
                                    <tr>
                                        <td class="fw-bold"><a href="job_detail.php?id=<?= $job['id'] ?>" class="text-decoration-none"><?= htmlspecialchars($job['title']) ?></a></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($job['category_name']) ?></span></td>
                                        <td><?= htmlspecialchars($job['location']) ?></td>
                                        <td><?= htmlspecialchars($job['job_type']) ?></td>
                                        <td class="text-success"><?= htmlspecialchars($job['salary'] ?? 'N/A') ?></td>
                                        <td>
                                            <a href="edit_job.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-primary me-1"><i class="fa-solid fa-pen"></i> Edit</a>
                                            <a href="employer_dashboard.php?delete_id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this job?');"><i class="fa-solid fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3 mb-0">You haven't posted any jobs yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Applications Section -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold">Candidate Applications Received</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($applications)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Applicant Name</th>
                                    <th>Email</th>
                                    <th>Applied For Job</th>
                                    <th>Resume</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applications as $app): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($app['seeker_name']) ?></td>
                                        <td><a href="mailto:<?= htmlspecialchars($app['seeker_email']) ?>"><?= htmlspecialchars($app['seeker_email']) ?></a></td>
                                        <td><?= htmlspecialchars($app['job_title']) ?></td>
                                        <td><a href="<?= htmlspecialchars($app['resume_path']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-download"></i> View Resume</a></td>
                                        <td>
                                            <?php if ($app['status'] === 'Accepted'): ?>
                                                <span class="badge bg-success">Accepted</span>
                                            <?php elseif ($app['status'] === 'Rejected'): ?>
                                                <span class="badge bg-danger">Rejected</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="employer_dashboard.php?app_action=accept&app_id=<?= $app['id'] ?>" class="btn btn-sm btn-success me-1"><i class="fa-solid fa-check"></i> Accept</a>
                                            <a href="employer_dashboard.php?app_action=reject&app_id=<?= $app['id'] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-xmark"></i> Reject</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3 mb-0">No applications received yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Post Job Modal -->
    <div class="modal fade" id="postJobModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="employer_dashboard.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Post a New Job</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Job Type</label>
                                <select class="form-select" name="job_type" required>
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Remote">Remote</option>
                                    <option value="Internship">Internship</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Salary Range</label>
                                <input type="text" class="form-control" name="salary" placeholder="e.g. $60,000 - $80,000">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Job Description</label>
                            <textarea class="form-control" name="description" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="post_job" class="btn btn-primary">Publish Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>