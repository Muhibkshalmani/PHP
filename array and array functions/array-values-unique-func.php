<?php
// array values fucntion is used with associative array mostly to get the values only to make a new array
// array unique function pick the unique values only and make a new array like it remove the duplicacy


$arrayA = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'alias' => 'John',
    'role' => 'editor'
];

$arrayB = [
    'primary_color' => 'blue',
    'secondary_color' => 'red',
    'accent_color' => 'blue',
    'favorite_color' => 'green',
    'accent_color' => 'blue'
];



$arrayc = array_values($arrayA);

print_r($arrayc);

echo "<br>";

// in  the above code we have get the values of arrayA;

$arrayc = array_unique($arrayB);

print_r($arrayc);


?>