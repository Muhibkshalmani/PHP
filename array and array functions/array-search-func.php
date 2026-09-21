<?php 
//  if we want to search any array value these two fucntion are use for this purpose

//  in_array()  ---> it will return 0 and 1 ,...1 for ture and 0 for false 
// array_search ---> this will return the key or the index and thats depend upon array whethere its indexed array or assosciative array 

$student = [
    "mashaal", "awais", "fawad", "zee"
];

echo in_array("mashaal",$student);
echo "<br>";


//  here I have used the in_array fucntion and it has returned 1 because  I have the searched value there in it 

echo array_search("mashaal", $student);

echo "<br>";

// and array-search function has returned 0 becuase the searched value is on indexed zero and it has a indexed array 


//in_array function  are often used with if and else condtion |


if (in_array("mashaal", $student)){
   echo "yes Mashaal is there in students";

}
else{
    echo "nope Mashaal is missing there";
}

?>