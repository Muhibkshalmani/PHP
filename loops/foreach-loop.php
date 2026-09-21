<?php 
// for each loop is specifically for arrays and its really important....

$numbers =array(
25,26,27,28,29,30
);


foreach($numbers as $num){

echo $num . "<br>";

};

// for each loop on associative array 

$ass = [
    "name" => "Mashaal",
    "age" => 28,
    "qualification" => "matric",
    "add"=> "Muhib-banda"
];

foreach ($ass as $info){
    echo $info . "<br>";
};

?>