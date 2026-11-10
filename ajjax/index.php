<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "student";

// Stops PHP from showing scary automatic errors
mysqli_report(MYSQLI_REPORT_OFF);

$conn = new mysqli($host, $user, $pass, $dbname);

// This part runs only when AJAX sends us an "action"
if (isset($_POST['action'])) {

    if ($conn->connect_error) {
        echo "Could not connect to the database. Check your settings at the top of the file.";
        exit;
    }

    $action = $_POST['action'];

    // ----- READ: send back the table rows as HTML -----
    if ($action == "read") {
        $result = $conn->query("SELECT * FROM students ORDER BY id DESC");

        if (!$result) {
            echo "<tr><td colspan='5'>Table not found. Did you run the SQL?</td></tr>";
            exit;
        }

        if ($result->num_rows == 0) {
            echo "<tr><td colspan='5' class='empty'>No students yet.</td></tr>";
            exit;
        }

        while ($row = $result->fetch_assoc()) {
            // htmlspecialchars keeps the page safe from bad input
            $id    = $row['id'];
            $name  = htmlspecialchars($row['name']);
            $email = htmlspecialchars($row['email']);
            $phone = htmlspecialchars($row['phone']);

            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$name</td>";
            echo "<td>$email</td>";
            echo "<td>$phone</td>";
            echo "<td>";
            echo "<button class='btn-edit' data-id='$id' data-name='$name' data-email='$email' data-phone='$phone'>Edit</button> ";
            echo "<button class='btn-delete' data-id='$id'>Delete</button>";
            echo "</td>";
            echo "</tr>";
        }
    }

    // ----- CREATE: add a new student -----
    if ($action == "create") {
        $name  = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);

        $stmt = $conn->prepare("INSERT INTO students (name, email, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $phone);

        if ($stmt->execute()) {
            echo "Student added!";
        } else {
            echo "Something went wrong: " . $stmt->error;
        }
    }

    // ----- UPDATE: change an existing student -----
    if ($action == "update") {
        $id    = $_POST['id'];
        $name  = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);

        $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $phone, $id);

        if ($stmt->execute()) {
            echo "Student updated!";
        } else {
            echo "Something went wrong: " . $stmt->error;
        }
    }

    // ----- DELETE: remove a student -----
    if ($action == "delete") {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Student deleted!";
        } else {
            echo "Something went wrong: " . $stmt->error;
        }
    }

    exit; // stop here, so the HTML below is not sent to AJAX
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CRUD</title>

    <!--
         PART 2: CSS (the design)
         -->
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .box {
            max-width: 800px;
            margin: 0 auto 20px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            margin-top: 0;
            color: #4f46e5;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-save   { background: #4f46e5; }
        .btn-cancel { background: #888; }
        .btn-edit   { background: #0ea5e9; padding: 6px 12px; }
        .btn-delete { background: #ef4444; padding: 6px 12px; }

        button:hover {
            opacity: 0.85;
        }

        #message {
            display: none;
            max-width: 800px;
            margin: 0 auto 20px auto;
            padding: 12px;
            background: #dcfce7;
            color: #166534;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #4f46e5;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tr:hover td {
            background: #f9fafb;
        }

        .empty {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>

    <!-- 
         PART 3: HTML (the page)
         -->
    <h1>Student Manager</h1>

    <div id="message"></div>

    <!-- The form (used for both adding and editing) -->
    <div class="box">
        <h2 id="formTitle">Add Student</h2>

        <form id="studentForm">
            <input type="hidden" id="id">

            <label>Name</label>
            <input type="text" id="name" placeholder="Enter name" required>

            <label>Email</label>
            <input type="email" id="email" placeholder="Enter email" required>

            <label>Phone</label>
            <input type="text" id="phone" placeholder="Enter phone">

            <button type="submit" class="btn-save" id="saveBtn">Save</button>
            <button type="button" class="btn-cancel" id="cancelBtn">Cancel</button>
        </form>
    </div>

    <!-- The table -->
    <div class="box">
        <h2>All Students</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentTable"></tbody>
        </table>
    </div>

    <!-- 
         PART 4: jQuery + AJAX (no page reload)
                                 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Load the table when the page opens
        loadStudents();

        // ----- READ: ask PHP for the rows and put them in the table -----
        function loadStudents() {
            $.post("index.php", { action: "read" }, function (data) {
                $("#studentTable").html(data);
            });
        }

        // ----- CREATE or UPDATE: when the form is submitted -----
        $("#studentForm").on("submit", function (event) {
            event.preventDefault(); // stops the page from reloading

            var id = $("#id").val();
            var action = "create";

            // If the hidden id has a value, we are editing
            if (id != "") {
                action = "update";
            }

            $.post("index.php", {
                action: action,
                id: id,
                name: $("#name").val(),
                email: $("#email").val(),
                phone: $("#phone").val()
            }, function (data) {
                showMessage(data);
                resetForm();
                loadStudents();
            });
        });

        // ----- EDIT: put the row's data into the form -----
        $("#studentTable").on("click", ".btn-edit", function () {
            $("#id").val($(this).attr("data-id"));
            $("#name").val($(this).attr("data-name"));
            $("#email").val($(this).attr("data-email"));
            $("#phone").val($(this).attr("data-phone"));

            $("#formTitle").text("Edit Student");
            $("#saveBtn").text("Update");
        });

        // ----- DELETE -----
        $("#studentTable").on("click", ".btn-delete", function () {
            var yes = confirm("Delete this student?");

            if (yes) {
                $.post("index.php", {
                    action: "delete",
                    id: $(this).attr("data-id")
                }, function (data) {
                    showMessage(data);
                    loadStudents();
                });
            }
        });

        // ----- CANCEL button -----
        $("#cancelBtn").on("click", function () {
            resetForm();
        });

        // ----- Small helper functions -----
        function resetForm() {
            $("#studentForm")[0].reset();
            $("#id").val("");
            $("#formTitle").text("Add Student");
            $("#saveBtn").text("Save");
        }

        function showMessage(text) {
            $("#message").text(text).show().delay(2500).fadeOut();
        }
    </script>

</body>
</html>