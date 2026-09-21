<?php
// these fucntions is spcially use for security to protect data from sql injection or hackers..
$a = "<a href='www.//https.php.com'> hello this is my site </a>";

echo htmlentities($a) . "<br>"; 
echo html_entity_decode($a) . "<br>"; 

echo htmlspecialchars($a) . "<br>"; 

echo htmlspecialchars_decode($a) . "<br>";



?>