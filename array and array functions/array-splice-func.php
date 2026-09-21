<?php
$student = array('Mashal','awaiskhan','Tomzi','cherry','munna','sahil');
$new_commers = array("saqlain","husnain","hassan");


array_splice($student, 1,3,$new_commers);


print_r($student);

echo "<br>";


// we can also delete values with this function 


array_splice($student, 3);
print_r($student);


?>