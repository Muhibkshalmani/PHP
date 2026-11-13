<?php
// ----- Tell the browser the reply is JSON -----
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// ----- Get the database connection -----
include "config.php";

// ----- Get the search word from the URL -----
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// ----- Look for the word in name, email and phone -----
$sql = "SELECT * FROM students WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
$result = mysqli_query($conn, $sql) or die("SQL Query Failed.");

// ----- If we found students, send them -----
if (mysqli_num_rows($result) > 0) {

    $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($output);

// ----- If nothing matched, send a message -----
} else {

    echo json_encode(array('message' => 'No Search Found.', 'status' => false));

}
?>