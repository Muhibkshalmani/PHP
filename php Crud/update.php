<?php
// 1. Connect to the database
$conn = mysqli_connect("localhost", "root", "", "php_crud_practice");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

// 2. Get the task ID from the URL using $_GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch the task data for this specific ID
    $query = "SELECT * FROM tasks WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $task = mysqli_fetch_assoc($result);

    // If no task is found with that ID
    if (!$task) {
        die("Task not found!");
    }
}

// 3. Handle form submission to update the record
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Simple SQL update query
    $sql = "UPDATE tasks SET title = '$title', description = '$description', status = '$status' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert success'>Task updated successfully!</div>";
        
        // Refresh the task data so the form shows the latest updated values
        $result = mysqli_query($conn, "SELECT * FROM tasks WHERE id = $id");
        $task = mysqli_fetch_assoc($result);
    } else {
        $message = "<div class='alert error'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Task</title>
</head>
<body>

    <div class="container">
        <h2>Update Task</h2>

        <?php echo $message; ?>

        <!-- Form pre-filled with existing task data -->
        <form method="POST" action="">
            <!-- Hidden input to pass the ID along with POST data -->
            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">

            <div class="form-group">
                <label>Task Title</label>
                <input type="text" name="title" value="<?php echo $task['title']; ?>" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description"><?php echo $task['description']; ?></textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Pending" <?php if ($task['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="In Progress" <?php if ($task['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                    <option value="Completed" <?php if ($task['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                </select>
            </div>

            <button type="submit" name="update">Update Task</button>
        </form>

        <div class="back-link">
            <a href="read.php">&larr; Back to Task List</a>
        </div>
    </div>

</body>
</html>

<!-- CSS placed at the very end of the file -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 40px;
        color: #333;
    }
    .container {
        max-width: 500px;
        margin: 0 auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    h2 {
        margin-top: 0;
        color: #2c3e50;
        text-align: center;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }
    input[type="text"], textarea, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }
    textarea {
        resize: vertical;
        height: 100px;
    }
    button {
        width: 100%;
        background-color: #f39c12;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }
    button:hover {
        background-color: #d68910;
    }
    .alert {
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
    }
    .alert.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .back-link {
        text-align: center;
        margin-top: 20px;
    }
    .back-link a {
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }
    .back-link a:hover {
        text-decoration: underline;
    }
</style>