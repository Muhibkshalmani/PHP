<?php
// logical operators used for the two or more then two coditions 
// &&,||,!,and,or,xor

$zee_age = 23;

if ($zee_age > 20 && $zee_age < 30){
    echo "yes he is eligible for vizza ";
}

echo "<br>";

// Here in and or && both condition should be true to print if there is one correct and other not still the statment will not be print;

$zee_age = 23;

if ($zee_age > 20 || $zee_age < 30){
    echo "yes he is still eligible for vizza ";
}

// in logical or operator there  should be just one condition must true to print the statment if both are not meeting then it will not;

echo "<br>";

$zee_age = 18;

if (!($zee_age > 20 &&  $zee_age < 30 )){
    echo "No he is not eligible for the vizza";
}

// the syntax of the not logical operator is a bit change if the conditions are not met then it will print nothing if met then it will 



?>