<?php 
// array slice function is work when we want to pick some values from an array to make  a new array 


$student = array('Mashal','awaiskhan','Tomzi','cherry','munna','sahil');

$slicefirst = array_slice($student,0,4);

print_r($slicefirst);

?>