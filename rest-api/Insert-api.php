<?php
// ----- Tell the browser the reply is JSON -----
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// -----  the database connection -----
include "config.php";

// ----- Read the data that was sent to us -----
$data = json_decode(file_get_contents("php://input"), true);

$name  = trim($data['name']);
$email = trim($data['email']);
$phone = trim($data['phone']);

// ----- Name and email must not be empty -----
if ($name == "" || $email == "") {
    echo json_encode(array('message' => 'Name and email are required.', 'status' => false));
    exit;
}

// ----- Insert the student -----
$stmt = mysqli_prepare($conn, "INSERT INTO students (name, email, phone) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);

// ----- Tell the front end if it worked -----
if (mysqli_stmt_execute($stmt)) {
    echo json_encode(array('message' => 'Student Inserted.', 'status' => true));
} else {
    echo json_encode(array('message' => 'Student Not Inserted.', 'status' => false));
}
?>