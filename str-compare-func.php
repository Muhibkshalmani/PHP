<?php
// these function work for comparsion between two string or more than two strings

$s1 = "Mashaal";
$s2 = "Mashaal";

echo strcmp($s1,$s2) . "<br>";


$s1 = "Mashaal";
$s2 = "mashaal";
echo strcmp($s1,$s2) . "<br>";

$s1 = "mashaal";
$s2 = "Mashaal";
echo strcmp($s1,$s2) . "<br>";

// these function are case sensitive 


$s1 = "mashaal";
$s2 = "Mashaal";
echo strcasecmp($s1,$s2) . "<br>";

// this is a case insensitive function


?>