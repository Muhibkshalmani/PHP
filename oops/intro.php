<?php

class calculation {            // 1. the class: a blueprint
    public $a, $b, $c;         // 2. properties: variables inside the class

    function sum() {           // 3. a method: a function inside the class
        $this->c = $this->a + $this->b;
        return $this->c;
    }

    function sub() {           // another method
        $this->c = $this->a - $this->b;
        return $this->c;
    }
}

$c1 = new calculation();       // 4. make an object from the class

$c1->a = 20;                   
$c1->b = 10;

echo $c1->a;
echo "<br>";
echo $c1->b;


echo "<br>";

echo "the sum of the a and b will be " .  $c1->sum() . "<br>";   
echo  "the subtraction of the b from a will be " . $c1->sub();   

?>