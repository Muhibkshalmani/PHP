<?php 
// another way to print the multi dimensional array data with any loop 

$newarray =[
    ["Mashaal","Azmat","tomzi"],
    ["black","red","blue"]
];

echo "<ul>";
foreach($newarray as list($name, $colors, $fav)){
    
echo "<li>" . $name . "  "  .$colors  . "   " . $fav  . "</li>";

}
echo "</ul>";

//  I have used the method and print the data in a ul or li tag 
?>