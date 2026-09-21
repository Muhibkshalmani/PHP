<?php
// these all functions are related to searching any word in a string 



$php = "I love php , php is more easy and understable langauge , php is a demanded language";

echo strstr($php, "php");
echo "<br>";


// strstr and strchr both are wroking same and  it will search fro the word you search in your string value and it will return the rest all values after finding that 

echo strrchr($php, "php");
echo "<br>";

// strrchr is  wroking same and just it will start searching from the end  it will search fro the word you search in your string value and it will return the rest all values after finding that 

// now these function look for a word to look for a charracter like a,b or any othere character we use strpbrk

echo strpbrk($php, "l");
echo "<br>";

?>