<?php
// these functions is used to change the existing array values but it will return a new array..

$fruit = array("banana","mango","cherry");
$add_fruit = array("apple","watermilon");

// Here we will add the add_fruit array to fruit array ..but it will return a new array 

$new = array_replace($fruit,$add_fruit);

Print_r ($new);

// arrray_replac function is work with simple indexed and associative array while replace_recurive work with complex arrays
// like associative multidimensional arrays 

$array1 = ["a"=>array("red"),"b"=> "yellwo"];
$array2 = ["a"=>array("black"),"b"=> "whie"];

$new_array = array_replace_recursive($array1,$array2);
echo "<pre>";

print_r($new_array);

echo "</pre>";

// the replace recursive method is used for complex array to replace any array value and make a new array;

?>