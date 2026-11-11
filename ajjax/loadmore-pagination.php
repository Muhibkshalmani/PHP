<?php
// ----- Database details (change these) -----
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "student";

mysqli_report(MYSQLI_REPORT_OFF);

// ----- Connect to the database -----
$conn = new mysqli($host, $user, $pass, $dbname);

// ----- Students to show at a time -----
$limit = 4;

// ----- Run this part only when ajax sends an offset -----
if (isset($_POST['offset'])) {

    // check the connection
    if ($conn->connect_error) {
        echo "Could not connect to the database.";
        exit;
    }

    // ----- How many rows are already on the page -----
    $offset = (int) $_POST['offset'];
    if ($offset < 0) {
        $offset = 0;
    }

    // ----- Get the next 4 students -----
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

    // ----- Are there more students left? -----
    if ($offset + $limit < $total) {
        $more = "yes";
    } else {
        $more = "no";
    }

    // ----- Send the rows and yes/no back together -----
    echo $rows . "||SPLIT||" . $more;

    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Load More</title>

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

        /* ----- Load more button ----- */
        #loadMoreBox {
            text-align: center;
            margin-top: 20px;
        }

        #loadMoreBtn {
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 24px;
            font-size: 14px;
            cursor: pointer;
        }

        #loadMoreBtn:hover {
            opacity: 0.85;
        }
    </style>
</head>
<body>

    <h1>Student List</h1>

    <!-- ----- Table and load more button ----- -->
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

        <div id="loadMoreBox">
            <button id="loadMoreBtn">Load More</button>
        </div>
    </div>

    <!-- ----- jQuery link ----- -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // ----- Name of this file (change it if you rename the file) -----
        var fileName = "loadmore-pagination.php";

        // ----- Show the first 4 students when the page opens -----
        loadStudents();

        // ----- Ask PHP for the next students -----
        function loadStudents() {
            // count the rows already in the table
            var offset = $("#studentTable tr").length;

            $.post(fileName, { offset: offset }, function (data) {
                // split the reply into rows and yes/no
                var parts = data.split("||SPLIT||");

                // add the new rows under the old ones
                $("#studentTable").append(parts[0]);

                // hide the button if there is nothing left
                if (parts[1] == "no") {
                    $("#loadMoreBtn").hide();
                }
            });
        }

        // ----- When the load more button is clicked -----
        $("#loadMoreBtn").on("click", function () {
            loadStudents();
        });
    </script>

</body>
</html>