<?php
// str find postions functions are use to find position of a  word inside the string value of a variable 

$php = "I love php , php is more easy and understable langauge , php is a demanded language";

echo strpos($php, "php");

echo "<br>";

echo strrpos($php, "php");

// these two functions are case sensitive to use insensitive functions use stripos and strripos


?>