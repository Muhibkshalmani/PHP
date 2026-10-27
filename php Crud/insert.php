<?php
// 1. Connect to the database
$conn = mysqli_connect("localhost", "root", "", "php_crud_practice");

// Check if connection works
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

// 2. Check if the submit button was clicked
if (isset($_POST['submit'])) {
    
    // Get values from the form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // 3. Write the insert query
    $sql = "INSERT INTO tasks (title, description, status) VALUES ('$title', '$description', '$status')";

    // Run the query and check if it worked
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert success'>Task added successfully!</div>";
    } else {
        $message = "<div class='alert error'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Task</title>
</head>
<body>

    <div class="container">
        <h2>Add a New Task</h2>

        <?php echo $message; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Task Title</label>
                <input type="text" name="title" required placeholder="Enter task title...">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" placeholder="Enter task description..."></textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <button type="submit" name="submit">Save Task</button>
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
        background-color: #3498db;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }
    button:hover {
        background-color: #2980b9;
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