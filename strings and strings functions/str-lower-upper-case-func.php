<?php
// these functions are used to change the string case from upper to lower or either from lower to upper 


$a = "Mashaal";

$result = strtolower($a);

echo $result;

echo "<br>";

$result = strtoupper($a);
echo $result;

echo "<br>";

$result = ucfirst($a);
echo $result;

$b = "Mashaal ";

echo "<br>";

$result = ucwords($b);
echo $result;

echo "<br>";

$result = lcfirst($b);
echo $result;


?>