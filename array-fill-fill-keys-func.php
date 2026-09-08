<?php
// array fill function is used for when we want to make any associative array values becomes keys of another associative array thier value will be fixed
// for indexed array we can use this function to put the indexed as we want ad also the value will be static or same in all index


$associativeArray = [
    'product_id' => 'PRD-9921',
    'title' => 'Mechanical Keyboard',
    'price' => 129.99,
    'in_stock' => true,
    'category' => 'Peripherals'
];

$indexedArray = ['apple', 'banana', 'cherry', 'date', 'elderberry'];


$result = array_fill_keys($indexedArray,"Mashaal");
print_r($result );

echo "<br>";

// array_fill_keys function help to make a associative array from index array by making the index array values as key of the associtve array and the value will be static

$newArray = array_fill(2,5,'Mashaal');

echo "<pre>";

print_r($newArray);

echo "</pre>";

?>