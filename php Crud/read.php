<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'php_crud_practice';

// Create the connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ==========================================
// 2. FETCH DATA FROM THE DATABASE
// ==========================================
$query = "SELECT * FROM tasks ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD - Read Operation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f6f9;
            color: #333;
        }
        h2 {
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 6px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            color: #fff;
            font-weight: bold;
        }
        .completed { background-color: #2ecc71; }
        .in-progress { background-color: #f39c12; }
        .pending { background-color: #e74c3c; }
    </style>
</head>
<body>
        <h2>Task List (Read Operation)</h2>
        <div style= "display:flex; justify-content:space-between;align-items:center;">
         <p>This data is being fetched dynamically from your MySQL database using MySQLi.</p>
         <div style= "display:flex; justify-content:space-between;align-items:center;">
         <a href="insert.php" style="display:flex;align-items:center;text-align:center;margin:0px 12px;padding: 8px 12px; background:black; color:white; border-radius:4px; text-decoration:none;"> Add a New Task</a>
         </div>
        </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Created At</th>
                <th>update/Delete</th>
            </tr>
        </thead>
        <tbody>
    <?php
    // Check if there are any records returned
    if (mysqli_num_rows($result) > 0) {
        
        // Fetch each row as an associative array and loop through them
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
            
            // Add badge styling depending on the task status
            $statusClass = '';
            if ($row['status'] == 'Completed') {
                $statusClass = 'completed';
            } elseif ($row['status'] == 'In Progress') {
                $statusClass = 'in-progress';
            } else {
                $statusClass = 'pending';
            }

            echo "<td><span class='badge " . $statusClass . "'>" . $row['status'] . "</span></td>";
            echo "<td>" . $row['created_at'] . "</td>";
            
            // Actions Column (Update & Delete buttons with dynamic IDs)
            echo "<td>";
            echo "<div style='display: flex;'>";
            echo "<a href='update.php?id=" . $row['id'] . "' style='display:flex;align-items:center;text-align:center;margin:0px 6px;padding: 6px 12px; background:black; color:white; border-radius:4px; text-decoration:none;'>Update</a>";
            echo "<a href='delete.php?id=" . $row['id'] . "' style='display:flex;align-items:center;text-align:center;margin:0px 6px;padding: 6px 12px; background:black; color:white; border-radius:4px; text-decoration:none;'>Delete</a>";
            echo "</div>";
            echo "</td>";

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6' style='text-align: center;'>No tasks found in the database.</td></tr>";
    }
    ?>
</tbody>
    </table>

</body>
</html>

<?php
// ==========================================
// 4. CLOSE THE DATABASE CONNECTION
// ==========================================
mysqli_close($conn);
?>