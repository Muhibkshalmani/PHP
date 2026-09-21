<?php
// nested loop is often used for when we want dipaly any data in tabular form ;

for($a= 1; $a <= 100; $a = $a+10){

for ($b=$a; $b < $a + 10; $b++){
echo "$b";
}

echo "<br>";

}

?>
