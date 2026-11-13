<?php
// ----- Tell the browser the reply is JSON -----
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');

// ----- Get the database connection -----
include "config.php";

// ----- Read the data that was sent to us -----
$data = json_decode(file_get_contents("php://input"), true);

// ----- Stop if nothing was sent -----
if ($data == null) {
    echo json_encode(array('message' => 'No data was sent.', 'status' => false));
    exit;
}

$id    = (int) $data['id'];
$name  = trim($data['name']);
$email = trim($data['email']);
$phone = trim($data['phone']);

// ----- Id, name and email must not be empty -----
if ($id == 0 || $name == "" || $email == "") {
    echo json_encode(array('message' => 'Id, name and email are required.', 'status' => false));
    exit;
}

// ----- Update the student with this id -----
$stmt = mysqli_prepare($conn, "UPDATE students SET name = ?, email = ?, phone = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $id);

// ----- Tell the front end if it worked -----
if (mysqli_stmt_execute($stmt)) {
    echo json_encode(array('message' => 'Student Updated.', 'status' => true));
} else {
    echo json_encode(array('message' => 'Student Not Updated.', 'status' => false));
}
?>