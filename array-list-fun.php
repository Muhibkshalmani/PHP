<?php
// array list fuction is used to store array values inside a string or variable 

// it wrok with index arrays and with those associative arrays which keys should be  numeric

$credentials = ['admin', 'secret123', 8080];

list($a, $b, $c) = $credentials;

echo $a . "<br>";
echo $b . "<br>";
echo $c . "<br>";

?>