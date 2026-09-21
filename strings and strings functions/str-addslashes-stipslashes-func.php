<?php
// these functions are use to add or remove slashes from the data or string value...
// these function is use to protect data from sql injection or from hackers 

$a = "this is me 'muhib'";

echo addslashes($a);

echo "<br>";

echo stripslashes($a);
echo "<br>";



?>