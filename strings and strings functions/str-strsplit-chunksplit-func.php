<?php
// str split function covert string to array and will save each string charrecter on a defferent index

//chunk split rto embed any character to a string values 



$a = "Mashaal";

$result = str_split($a,1);


echo "<pre>";

print_r($result);

echo "</pre>";


$b = "Mashaal";
$ressultt=chunk_split($b,1,"-");
echo $ressultt;


?>