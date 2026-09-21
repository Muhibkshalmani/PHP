<?php
// array rand fucntion work with when we too print a random value of an array;
$settings = [
    'theme' => 'dark',
    'notifications' => 'enabled',
    'layout' => 'compact',
    'auto_save' => true,
    'cache' => false,
    'items_per_page' => 25
];

$result = array_rand($settings,2);
print_r($result);


//array shuffle function change array values position with refresh 

echo "<br>";

shuffle($settings);
print_r($settings);




?>