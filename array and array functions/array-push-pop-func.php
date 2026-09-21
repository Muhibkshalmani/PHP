<?php
// to add a new value or delete any last value from existing array there is function used for it 

//pop function for delet
// push function for adding new value to an existing array 


$student = array("awais","zee","fawad","hamad");

array_pop($student);

print_r($student);

echo "<br>";

// how to delete last value of the any array

$student = array("awais","zee","fawad","hamad");
array_push($student,"Mashaal");

print_r($student);

// This is how to add a new value to an existing array 

?>