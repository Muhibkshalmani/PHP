<?php
// these functions work to add or replace any or charracter inside in a existing string ..
// str_replace(search,replace,string);


$php = "I love php , php is more easy and understable langauge , php is a demanded language";

echo str_replace("php","java",$php);
echo "<br>";

// Note this fucntion is case sensitive

$php = "I love pHp , Php is more easy and understable langauge , phP is a demanded language";
echo str_ireplace("php","java",$php);


// Note this fucntion is case insensitive it will look for the character and will match that what we have 


echo "<br>";


$php = "I love pHp , Php is more easy and understable langauge , phP is a demanded language";

echo substr_replace($php,"java is more complicated",20,);

// this function work like to add a new value inside in aexisting string if we give length it will add from starting till if not 
// then it will not  print after the added new string ...

echo "<br>";


$php = "I love pHp , Php is more easy and understable langauge , phP is a demanded language";

echo "O has been replaced with : 0 as you can see  below <br>  " . strtr($php,"o",0);




?>