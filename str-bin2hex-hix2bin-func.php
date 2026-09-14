<?php

// these functions are used to convert a string value into hexa or hex number or to convert hex to string 
// these functions are used for security purpose;

$Name = "Mashal Khan";

$hex = bin2hex($Name);

echo $hex . "<br>";


$hix = hex2bin($hex);

echo $hix . "<br>";




?>