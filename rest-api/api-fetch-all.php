<?php
// ----- Tell the browser the reply is JSON -----
header('Content-Type: application/json');

// ----- Get the database connection -----
include "config.php";

// ----- Get all the students -----
$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql) or die("SQL Query Failed.");

// ----- If we found students, send them -----
if (mysqli_num_rows($result) > 0) {

    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($output);

// ----- If the table is empty, send a message -----
} else {

    echo json_encode(array('message' => 'No Record Found.', 'status' => false));

}
?>
