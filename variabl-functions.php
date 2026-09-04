<?php


// this is how we can write a varible function and how we can call it 


function variable(){

echo "hey this is the php variable function";

}

$varfunc = "variable";

echo $varfunc();


// we can also assign the complete function to a variable and then print that varaible which is also called anonymous function 


$ano = function (){
echo " <br> hello this is another way to write the php varibale fucntion or anonymous function";

};

$ano();

?>