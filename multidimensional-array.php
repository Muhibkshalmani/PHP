<?php 


// multidiemensional array or nested array 


$multi =[
    [1, "mashaal", "fsc", "muhib banda"],
    [2, "Awais", "graduate", "peshawar"],
    [3, "fawad", "fsc", "lahore"],
    [4, "zee", "matric", "Shalman"]
];



// printing evey single value will take alot of time and as well we have to write a lot of code 
//  this is how to print array with for loop

for ( $row =0; $row <4 ; $row ++){
for ( $col =0; $col <4 ; $col++){

     echo $multi[$row][$col] . "     ";

}

echo "<br>";

}



// printing the same array with for each loop 


echo "<div style ='padding:50px 0px;background:gray; border-top:1px solid red;'>";

foreach ($multi as $array1){
foreach ($array1 as $array2){
echo $array2 . "  ";

}

echo " <br>";


}
echo "</div>";






?>