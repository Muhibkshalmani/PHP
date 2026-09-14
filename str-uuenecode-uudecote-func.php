<?php
// these functions are used to send any data or save any data securly or secretly 

$name = "Mashaal";

$coded =  convert_uuencode($name);

echo $coded . "<br>";




echo convert_uudecode($coded) . "<br>";

// this is how convert_uuencode and decode function work ;

?>