<?php
session_start();

// Security check: Only allow logged-in admins
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['user_id'];
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

    // Handle Job Deletion by Admin
    if (isset($_GET['delete_job_id'])) {
        $delete_job_id = $_GET['delete_job_id'];
        $stmt_del_job = $pdo->prepare("DELETE FROM jobs WHERE id = ?");
        if ($stmt_del_job->execute([$delete_job_id])) {
            $success = "Job deleted successfully by admin.";
        } else {
            $error = "Failed to delete job.";
        }
    }

    // Handle User/Member Deletion by Admin
    if (isset($_GET['delete_user_id'])) {
        $delete_user_id = $_GET['delete_user_id'];
        
        // Prevent admin from deleting themselves
        if ($delete_user_id == $admin_id) {
            $error = "You cannot delete your own admin account.";
        } else {
            $stmt_del_user = $pdo->prepare("DELETE FROM users WHERE id = ?");
            if ($stmt_del_user->execute([$delete_user_id])) {
                $success = "Member account deleted successfully.";
            } else {
                $error = "Failed to delete member account.";
            }
        }
    }

    // Fetch Statistics
    $total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $total_jobs = $pdo->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
    $total_applications = $pdo->query("SELECT COUNT(*) FROM applications")->fetchColumn();

    // Fetch All Jobs with Employer & Category Details
    $all_jobs = $pdo->query("SELECT jobs.*, users.name AS employer_name, categories.name AS category_name 
                             FROM jobs 
                             JOIN users ON jobs.employer_id = users.id 
                             JOIN categories ON jobs.category_id = categories.id 
                             ORDER BY jobs.created_at DESC")->fetchAll();

    // Fetch All Members (Users)
    $all_users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();

    // Fetch All Applications
    $all_applications = $pdo->query("SELECT applications.*, jobs.title AS job_title, seekers.name AS seeker_name, employers.name AS employer_name 
                                    FROM applications 
                                    JOIN jobs ON applications.job_id = jobs.id 
                                    JOIN users AS seekers ON applications.seeker_id = seekers.id 
                                    JOIN users AS employers ON jobs.employer_id = employers.id 
                                    ORDER BY applications.applied_at DESC")->fetchAll();

} catch (\PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - JobPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="homepage.php"><i class="fa-solid fa-briefcase text-primary me-2"></i>JobPortal <span class="badge bg-danger fs-6 ms-2">Admin Panel</span></a>
            <div class="ms-auto d-flex align-items-center">
                <a href="homepage.php" class="btn btn-outline-light btn-sm me-3">Home</a>
                <span class="text-white me-3">Admin: <?= htmlspecialchars($_SESSION['user_name']) ?></span>
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

        <h2 class="fw-bold mb-4">Admin Control Dashboard</h2>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 bg-white border-start border-primary border-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 font-monospace">TOTAL MEMBERS</p>
                            <h3 class="fw-bold mb-0"><?= $total_users ?></h3>
                        </div>
                        <div class="text-primary fs-1"><i class="fa-solid fa-users"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 bg-white border-start border-success border-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 font-monospace">POSTED JOBS</p>
                            <h3 class="fw-bold mb-0"><?= $total_jobs ?></h3>
                        </div>
                        <div class="text-success fs-1"><i class="fa-solid fa-briefcase"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 bg-white border-start border-warning border-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 font-monospace">APPLICATIONS</p>
                            <h3 class="fw-bold mb-0"><?= $total_applications ?></h3>
                        </div>
                        <div class="text-warning fs-1"><i class="fa-solid fa-file-lines"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 1: Manage Members -->
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold"><i class="fa-solid fa-users-gear me-2 text-primary"></i>Manage All Members</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($all_users)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Joined Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_users as $usr): ?>
                                    <tr>
                                        <td><?= $usr['id'] ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($usr['name']) ?></td>
                                        <td><a href="mailto:<?= htmlspecialchars($usr['email']) ?>"><?= htmlspecialchars($usr['email']) ?></a></td>
                                        <td>
                                            <?php if ($usr['role'] === 'admin'): ?>
                                                <span class="badge bg-danger">Admin</span>
                                            <?php elseif ($usr['role'] === 'employer'): ?>
                                                <span class="badge bg-primary">Employer</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Job Seeker</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($usr['created_at'])) ?></td>
                                        <td>
                                            <?php if ($usr['id'] != $admin_id): ?>
                                                <a href="admin_dashboard.php?delete_user_id=<?= $usr['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user? This will also remove their related posts/applications.');"><i class="fa-solid fa-trash"></i> Delete</a>
                                            <?php else: ?>
                                                <span class="text-muted small">Current Admin</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3 mb-0">No users found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Section 2: Manage Jobs -->
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold"><i class="fa-solid fa-list-check me-2 text-success"></i>Manage All Job Postings</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($all_jobs)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Employer</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_jobs as $job): ?>
                                    <tr>
                                        <td class="fw-bold"><a href="job_detail.php?id=<?= $job['id'] ?>" class="text-decoration-none" target="_blank"><?= htmlspecialchars($job['title']) ?></a></td>
                                        <td><?= htmlspecialchars($job['employer_name']) ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($job['category_name']) ?></span></td>
                                        <td><?= htmlspecialchars($job['location']) ?></td>
                                        <td><?= htmlspecialchars($job['job_type']) ?></td>
                                        <td>
                                            <a href="admin_dashboard.php?delete_job_id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this job posting?');"><i class="fa-solid fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3 mb-0">No job openings available.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Section 3: All Applications -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold"><i class="fa-solid fa-file-invoice me-2 text-warning"></i>All System Applications</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($all_applications)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Job Title</th>
                                    <th>Employer</th>
                                    <th>Job Seeker</th>
                                    <th>Resume</th>
                                    <th>Status</th>
                                    <th>Applied Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_applications as $app): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($app['job_title']) ?></td>
                                        <td><?= htmlspecialchars($app['employer_name']) ?></td>
                                        <td><?= htmlspecialchars($app['seeker_name']) ?></td>
                                        <td><a href="<?= htmlspecialchars($app['resume_path']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-download"></i> Resume</a></td>
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
                    <p class="text-muted text-center py-3 mb-0">No applications recorded in the system yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>