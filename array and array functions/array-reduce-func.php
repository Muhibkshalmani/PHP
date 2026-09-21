<?php

// array reduce  fucntion is use when we want all the value should be shown in a single like if that is integers so it will print it as all 
// if that is string it willl store that as string and will make a new of that ...



function  reduce_func( $n, $m){
return $n . $m;

}

$numbers = [14, 3, 27, 8, 42, 19, 55, 6];

$result = array_reduce($numbers, "reduce_func");

echo "<pre>";
print_r($result);
echo "</pre>";

echo "<br>";
function php_function($convert,$into_one_string){
    return $convert . $into_one_string . " " ;
}


$words = ['PHP', 'is', 'a', 'powerful', 'scripting', 'language'];

$php = array_reduce($words,"php_function");

echo "<pre>";
print_r($php);
echo "</pre>";


?>