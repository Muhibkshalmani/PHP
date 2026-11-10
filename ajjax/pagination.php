<?php
// ----- Database details (change these) -----
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "student";

mysqli_report(MYSQLI_REPORT_OFF);

// ----- Connect to the database -----
$conn = new mysqli($host, $user, $pass, $dbname);

// ----- Students per page -----
$limit = 4;

// ----- Run this part only when ajax sends a page number -----
if (isset($_POST['page'])) {

    // check the connection
    if ($conn->connect_error) {
        echo "Could not connect to the database.";
        exit;
    }

    // ----- Get the page number -----
    $page = (int) $_POST['page'];
    if ($page < 1) {
        $page = 1;
    }

    // ----- Skip the rows of the earlier pages -----
    $offset = ($page - 1) * $limit;

    // ----- Get the students for this page -----
    $result = $conn->query("SELECT * FROM students ORDER BY id ASC LIMIT $limit OFFSET $offset");

    // ----- Make the table rows -----
    $rows = "";
    while ($row = $result->fetch_assoc()) {
        $rows .= "<tr>";
        $rows .= "<td>" . $row['id'] . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['name']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['email']) . "</td>";
        $rows .= "<td>" . htmlspecialchars($row['phone']) . "</td>";
        $rows .= "</tr>";
    }

    // ----- Count all the students -----
    $countResult = $conn->query("SELECT COUNT(*) AS total FROM students");
    $countRow = $countResult->fetch_assoc();
    $total = $countRow['total'];

    // ----- Find the total pages -----
    $totalPages = ceil($total / $limit);

    // ----- Make the page buttons -----
    $buttons = "";
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            $buttons .= "<button class='page-btn active' data-page='$i'>$i</button> ";
        } else {
            $buttons .= "<button class='page-btn' data-page='$i'>$i</button> ";
        }
    }

    // ----- Send the rows and buttons back together -----
    echo $rows . "||SPLIT||" . $buttons;

    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Pagination</title>

    <style>
        /* ----- Basic page style ----- */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        /* ----- White box around the table ----- */
        .box {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* ----- Table style ----- */
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

        /* ----- Page buttons ----- */
        #pagination {
            text-align: center;
            margin-top: 20px;
        }

        .page-btn {
            background: #e5e7eb;
            color: #333;
            border: none;
            border-radius: 6px;
            padding: 8px 14px;
            margin: 0 2px;
            font-size: 14px;
            cursor: pointer;
        }

        .page-btn:hover {
            background: #d1d5db;
        }

        /* the page we are on */
        .page-btn.active {
            background: #4f46e5;
            color: white;
        }
    </style>
</head>
<body>

    <h1>Student List</h1>

    <!-- ----- Table and page buttons ----- -->
    <div class="box">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody id="studentTable"></tbody>
        </table>

        <div id="pagination"></div>
    </div>

    <!-- ----- jQuery link ----- -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // ----- Name of this file (change it if you rename the file) -----
        var fileName = "pagination.php";

        // ----- Show page 1 when the page opens -----
        loadPage(1);

        // ----- Ask PHP for one page of data -----
        function loadPage(page) {
            $.post(fileName, { page: page }, function (data) {
                // split the reply into rows and buttons
                var parts = data.split("||SPLIT||");

                // show them on the page
                $("#studentTable").html(parts[0]);
                $("#pagination").html(parts[1]);
            });
        }

        // ----- When a page button is clicked -----
        $("#pagination").on("click", ".page-btn", function () {
            var page = $(this).attr("data-page");
            loadPage(page);
        });
    </script>

</body>
</html>