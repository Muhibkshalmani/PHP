<?php
// array sorting functions 

$indexedArray = [45, 12, 89, 3, 23, 67];

$associativeArray = [
    'banana' => 35,
    'apple' => 10,
    'cherry' => 50,
    'date' => 20
];

sort ($indexedArray);

echo "<pre>";
print_r($indexedArray);
echo "</pre>";

echo "<br>";

rsort ($indexedArray);

echo "<pre>";
print_r($indexedArray);
echo "</pre>";

echo "<br>";



echo "<br>";

asort ($associativeArray);

echo "<pre>";
print_r($associativeArray);
echo "</pre>";

echo "<br>";

echo "<br>";

arsort ($associativeArray);

echo "<pre>";
print_r($associativeArray);
echo "</pre>";

echo "<br>";

ksort ($associativeArray);

echo "<pre>";
print_r($associativeArray);
echo "</pre>";

echo "<br>";

krsort ($associativeArray);

echo "<pre>";
print_r($associativeArray);
echo "</pre>";

echo "<br>";

?>