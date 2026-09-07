<?php
$student =array("mashaal","cherry","sahil");

$item =array("bag","pensil","book");

$merged_new = array_merge($student,$item);

print_r($merged_new);

// this is how array_merge fucntion work


echo "<br>";

$name =["Mashal","awais","Munna"];

$age =[18,23,26];

$combi = array_combine($name,$age);


print_r($combi);

// combine array function only work on indexed array

?>