<?php
// 1. Connect to the database
$conn = mysqli_connect("localhost", "root", "", "php_crud_practice");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 2. Check if ID exists in the URL
if (!isset($_GET['id'])) {
    header("Location: read.php");
    exit();
}

$id = $_GET['id'];

// 3. If user clicks "Yes", delete the record and redirect
if (isset($_POST['yes'])) {
    $sql = "DELETE FROM tasks WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: read.php"); // Change to read.php if your main file is named read.php
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// 4. If user clicks "No", cancel and redirect back
if (isset($_POST['no'])) {
    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Task</title>
</head>
<body>

    <div class="container">
        <h2>Are you sure you want to delete this task?</h2>

        <form method="POST" action="">
            <div class="button-group">
                <button type="submit" name="yes" class="btn btn-yes">Yes</button>
                <button type="submit" name="no" class="btn btn-no">No</button>
            </div>
        </form>
    </div>

</body>
</html>

<!-- CSS placed at the very end of the file -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 100px 20px;
        color: #333;
        display: flex;
        justify-content: center;
    }
    .container {
        max-width: 400px;
        width: 100%;
        background: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    h2 {
        margin-top: 0;
        color: #2c3e50;
        font-size: 18px;
        margin-bottom: 25px;
    }
    .button-group {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    .btn {
        padding: 10px 30px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        color: white;
    }
    .btn-yes {
        background-color: #e74c3c;
    }
    .btn-yes:hover {
        background-color: #c0392b;
    }
    .btn-no {
        background-color: #7f8c8d;
    }
    .btn-no:hover {
        background-color: #636e72;
    }
</style>