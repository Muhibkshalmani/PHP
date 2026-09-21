<?php
// these functions are used for defferent purposes in in php 
// counting length / of a word include space as well it will return the value of charracters
// searching for a word inside a string 
// adn counting values or words inside a string it will also return the value of words 

$a = "Mashaal khan";

$result = strlen($a);
echo $result;


echo "<br>";
$result = str_word_count($a);
echo $result;

$Name = "Mashaal Fahad Mashaal  Awais  Mashaal furqan  Mashaal ";
echo "<br>";
$result = substr_count($Name, "Mashaal");
echo $result;


?>