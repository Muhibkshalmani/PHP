<?php
// ----- Database details (change these) -----
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "student";

// ----- Connect to the database -----
$conn = mysqli_connect($host, $user, $pass, $dbname) or die("Connection Failed.");
?>