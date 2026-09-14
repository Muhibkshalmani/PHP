<?php
// strip tags is use fopr to remove any tags property from string or any value

$name = "<h1> Zeeshan </h1>";

echo strip_tags($name) . "<br>";


// wordwrap fucniton is use to wrap any string values or paragraph 

$Name = "Zeeshan ";

echo wordwrap($Name, 1, "<br>", TRUE);

?>