<?php
// array map function is use for passing a user define function which will return a new array 
// it is same like array_walk function But there are 2 defference 
// we can pass multiple arrays here as a parameter
// it will returned a new array .....


function func_tion( $n ){

return $n . "s";

}

function New_func( $n ){

return strtoupper($n);

}

$userProfile = [
    'id' => 1042,
    'username' => 'dev_guru',
    'email' => 'dev@example.com',
    'role' => 'administrator',
    'is_active' => true,
    'login_count' => 158,
    'last_login' => '2026-09-08'
];

$result = array_map("func_tion", $userProfile );


echo "<pre>";
print_r($result);
echo "</pre>";

echo "<br>";


$result = array_map("New_func", $userProfile );


echo "<pre>";
print_r($result);
echo "</pre>";
// here we have call our own function where I change the case of the array values ot to upper 
?>