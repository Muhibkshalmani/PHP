<?php
// to add or delete any value from the start or to the start of any array we use these fucntions
// array_shif to delet the first value
// array_unshift to add a new value to the start 


// array_shit()

$student = array("Tomzi","zee","ayan");
array_shift($student);

print_r($student);

echo "<br>";



// array_unshift()

$student = array("Tomzi","zee","ayan");
array_unshift($student,"Mashaal");

print_r($student);


?>