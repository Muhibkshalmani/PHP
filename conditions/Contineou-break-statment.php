<?php
// in php we use the contineou and break statment for a specific function like if we want to stop loop when condition met
// or when we want to skip the item when the condition met 

for ($a=1; $a <=10; $a++){

if($a==3){
continue;

}

echo $a . "<br>";


}

echo "<br>";

// here in the above code loop skipped printing $a value when it == 3; means printing 3 id skipped cuz of continue statment
// 

for ($b=1; $b <=10; $b++){

if($b==3){
break;

}

echo $b . "<br>";


}
// break statment when condition met it will stop loop to print more data as showing above when condtion met $b==3 it will stop printing

?>