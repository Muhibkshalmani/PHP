<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'employer') {
    header("Location: login.php");
    exit;
}

$employer_id = $_SESSION['user_id'];
$job_id = $_GET['id'] ?? null;
$error = '';
$success = '';

if (!$job_id) {
    header("Location: employer_dashboard.php");
    exit;
}

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

    // Handle form submission for update
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = trim($_POST['title']);
        $category_id = $_POST['category_id'];
        $location = trim($_POST['location']);
        $salary = trim($_POST['salary']);
        $job_type = $_POST['job_type'];
        $description = trim($_POST['description']);

        if (empty($title) || empty($category_id) || empty($location) || empty($description)) {
            $error = "Please fill in all required fields.";
        } else {
            $stmt = $pdo->prepare("UPDATE jobs SET title = ?, category_id = ?, location = ?, salary = ?, job_type = ?, description = ? WHERE id = ? AND employer_id = ?");
            if ($stmt->execute([$title, $category_id, $location, $salary, $job_type, $description, $job_id, $employer_id])) {
                $success = "Job updated successfully!";
            } else {
                $error = "Failed to update job.";
            }
        }
    }

    // Fetch Job Data
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = ? AND employer_id = ?");
    $stmt->execute([$job_id, $employer_id]);
    $job = $stmt->fetch();

    if (!$job) {
        header("Location: employer_dashboard.php");
        exit;
    }

    $categories = $pdo->query("SELECT * FROM categories")->fetchAll();

} catch (\PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job - JobPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="employer_dashboard.php"><i class="fa-solid fa-arrow-left me-2"></i>Back to Dashboard</a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 p-4">
                    <h3 class="fw-bold mb-4">Edit Job Listing</h3>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <form action="edit_job.php?id=<?= $job_id ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($job['title']) ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category_id" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $job['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Job Type</label>
                                <select class="form-select" name="job_type" required>
                                    <option value="Full-time" <?= $job['job_type'] == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                                    <option value="Part-time" <?= $job['job_type'] == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                                    <option value="Remote" <?= $job['job_type'] == 'Remote' ? 'selected' : '' ?>>Remote</option>
                                    <option value="Internship" <?= $job['job_type'] == 'Internship' ? 'selected' : '' ?>>Internship</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" value="<?= htmlspecialchars($job['location']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Salary Range</label>
                                <input type="text" class="form-control" name="salary" value="<?= htmlspecialchars($job['salary']) ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Job Description</label>
                            <textarea class="form-control" name="description" rows="6" required><?= htmlspecialchars($job['description']) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Update Job</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>