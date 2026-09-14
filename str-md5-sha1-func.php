<?php

// these functions are mostly use for security specifically for passwords and users name 

$password ="Hello@jaan";
echo md5($password) . "<br>";

echo md5($password,"True") . "<br>";

// this is how md5 syntax should be 


echo sha1($password) . "<br>";

echo sha1($password,"True") . "<br>";

// this is how sha1 syntax should be and its more secure and harder than the md5

?>