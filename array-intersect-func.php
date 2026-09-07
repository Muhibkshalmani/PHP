<?php

// array intersect functions work fro getting the common values or key from one or more than one arrays 


$arrayA = [
    'id' => 101,
    'status' => 'active',
    'role' => 'editor',
    'tier' => 'gold'
];

$arrayB = [
    'id' => 101,
    'status' => 'pending',
    'role' => 'editor',
    'plan' => 'free'
];

$inters = array_intersect($arrayA,$arrayB);

if ($inters){
echo "yes the common values are";
echo "<br>";
print_r($inters) ;
}else{
    echo "nope there is not any common values";
};

echo "<br>";
$inters = array_intersect_key($arrayA,$arrayB);

if ($inters){
echo "yes the common keys are";
echo "<br>";
print_r($inters) ;
}else{
    echo "nope there is not any common values";
};

echo "<br>";
$inters = array_intersect_assoc($arrayA,$arrayB);

if ($inters){
echo "yes the common keys and values are";
echo "<br>";
print_r($inters) ;
}else{
    echo "nope there is not any common values";
};

?>