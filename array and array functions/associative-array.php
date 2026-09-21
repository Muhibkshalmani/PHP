<?php 
// In indexed array we simple assign or prin tthe array data by its index number |
//  In associative array we can assign string value to the data to print it ater 



$ass = array (
    "cherry"=> "lovely",
    "Janan"=> "Life",
    "Mashaal"=> "mature",
    "sahil"=> "handsome"
);

?>

<h2 style ="color:red; font-size:45px;"><?php
echo $ass ["Janan"];


?>
</h2>
<!-- another way to write associative array in php  -->

<?php
$ass =[
    "cherry"=> "lovely",
    "Janan"=> "Life",
    "Mashaal"=> "mature",
    "sahil"=> "handsome"
];

echo $ass ["cherry"] . '<br>';

// here in associative array the right side where we assign the value called key and the left side is value 
// like in the above case "cherry" is  key and "lovely" is value;

//  if we want to change any key value so we can change it like this

$ass["cherry"]="super cute ";

echo $ass ["cherry"];
?>
<!-- we can have the keys of any data type and as well as wecan hav e the value of any data type as well -->