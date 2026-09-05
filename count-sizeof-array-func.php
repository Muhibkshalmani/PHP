<?php
// size off and count function ...

$newarray = array("mango", "aaple", "banan", "cherry");

echo sizeof($newarray);

echo "<br>";

$newarray = array("mango", "aaple", "banan", "cherry");

echo count($newarray);

echo "<br>";

// How to count multi dimensional array values with these functions 

$multi =[
    ["muhib",1,"fcs","software-dev"],
    ["Awais",2,"Graduate","wordpress expert"],
];

echo sizeof ( $multi, 1);


//  Now if we want  display this with loop then  how we will 

echo "<br>";


$vegi = array("carrots","cucumber","potato","tomato");

$length = sizeof ($vegi);

for ( $i=0; $i<$length;$i++){
    echo $vegi[$i] . "<br>";
};

// Values 

//  4 and 4 cuz we have print the same array above with defferent functions 
//  10 for the multi dimension array we have 2 values or array nested in the parrent array and 4,4 values inside each nested array

?>