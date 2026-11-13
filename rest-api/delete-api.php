<?php
// ----- Tell the browser the reply is JSON -----
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');

// ----- Get the database connection -----
include "config.php";

// ----- Read the data that was sent to us -----
$data = json_decode(file_get_contents("php://input"), true);

// ----- Stop if nothing was sent -----
if ($data == null) {
    echo json_encode(array('message' => 'No data was sent.', 'status' => false));
    exit;
}

// ----- Get the id (the (int) makes sure it is a number) -----
$id = (int) $data['id'];

// ----- The id must not be empty -----
if ($id == 0) {
    echo json_encode(array('message' => 'Id is required.', 'status' => false));
    exit;
}

// ----- Delete the student with this id -----
$sql = "DELETE FROM students WHERE id = $id";
mysqli_query($conn, $sql);

// ----- Check if a row was really deleted -----
if (mysqli_affected_rows($conn) > 0) {
    echo json_encode(array('message' => 'Student Deleted.', 'status' => true));
} else {
    echo json_encode(array('message' => 'Student Not Found.', 'status' => false));
}
?>