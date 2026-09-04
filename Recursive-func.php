<?php
// calling a function in a funcation often use recursive function
//  it is working like a loop ....

function number($num){
if ($num <= 5){

echo $num . "<br>";

number( $num + 1 );
}
}

number(1);


?>