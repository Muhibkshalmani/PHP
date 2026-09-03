<?php

// Here requirded age for the licenese is 18years ;
// if junaid is age above 18 so it will print the statment below if not then it will print nothing  

$junaid_age=30;

if ($junaid_age > 18 ) {
echo "yes he is eligible for the driving license ";
}

echo"<br>";

// we can write the if statment or condition id another way as well like 

$zeeshan_age=30;

if ($junaid_age > 18 ):
echo "yes zee  is eligible for the driving license ";
endif;

?>