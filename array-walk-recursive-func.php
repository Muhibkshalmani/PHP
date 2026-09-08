<?php
// array walk and array walk recursive functions are use for to run a user define funciton for every key or vlaue of the array 
// array walk work well with index and associative array 
// while array walk recusrive work well with multidimensional array 

$config = [
    'debug' => true,
    'version' => '1.0'
];


$associativeArray1 = [
    $config,
    'product_id' => 'PRD-9921',
    'title' => 'Mechanical Keyboard',
    'price' => 129.99,
    'in_stock' => true,
    'category' => 'Peripherals'
];

$associativeArray = [
    'price' => 129.99,
    'in_stock' => true,
    'category' => 'Peripherals'
];





array_walk($associativeArray,"myfunction");

function myfunction($value, $key){
echo "  $key :  $value   <br>";
}

// here we have used array walk function and inside that we have call our own function where we have print the values 

echo "<br>";


array_walk_recursive($associativeArray1,"myfunc");

function myfunc($value, $key){
echo "  $key :  $value   <br>";
}
// here we have used array_walk_recursiv function and inside that we have call our own function where we have print the values 


?>