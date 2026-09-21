<?php
//  string explode funciton is is used to convert string values into array 
//  and explode to convert array into string 



$wordsArray = ['PHP', 'is', 'a', 'powerful', 'language'];

$csvString = "apple,banana,cherry,date,elderberry";


$result = explode(",",$csvString);

echo "<pre>";
print_r($result);
echo "</pre>";

echo "<br>";


$result = implode(" ",$wordsArray);

echo "<pre>";
print_r($result);
echo "</pre>";




?>