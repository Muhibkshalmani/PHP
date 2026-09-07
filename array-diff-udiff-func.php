<?php

$arrayA = [
    'id' => 101,
    'status' => 'Active',
    'role' => 'editor',
    'tier' => 'gold'
];

$arrayB = [
    'id' => 101,
    'status' => 'active',
    'role' => 'editor',
    'access' => 'full'
];

$arrayc = [
    'id' => 101,
    'status' => 'Active',
    'role' => 'editor',
    'tier' => 'gold'
];

$deff = array_diff($arrayA, $arrayB);

if (!empty ($deff)){
    echo "the defferent values in these arrays are";
    echo "<br>";
    print_r($deff);

}else{
    echo "nope there no defferent values inside these arrays";

}

// in the above code we have defferent values so it will print them in a new array 

echo"<br>";

$deff = array_diff($arrayA, $arrayc);

if (!empty ($deff)){
    echo "the defferent values in these arrays are";
    echo "<br>";
    print_r($deff);

}else{
    echo "nope there no defferent values inside these arrays";
}

// in the above we are not having defferent values so it will  print the else part of the condition

// for keys 

echo"<br>";


$deff = array_diff_key($arrayA, $arrayB);

if (!empty ($deff)){
    echo "the defferent keys in these arrays are";
    echo "<br>";
    print_r($deff);

}else{
    echo "nope there no defferent values inside these arrays";

}

// for both defferent  keys and values 

echo"<br>";


$deff = array_diff_assoc($arrayA, $arrayB);

if (!empty ($deff)){
    echo "the defferent values and keys  in these arrays are";
    echo "<br>";
    print_r($deff);

}else{
    echo "nope there no defferent values inside these arrays";

}

// this function case sensitive remmeber and this function is only work with associative array only 

?>