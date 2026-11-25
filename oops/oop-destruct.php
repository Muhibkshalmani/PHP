<?php

class Student {
    public $name;

    // runs when the object is created
    public function __construct($n) {
        $this->name = $n;
        echo $this->name . " object created<br>";
    }

    // runs when the object is destroyed
    public function __destruct() {
        echo $this->name . " object destroyed<br>";
    }
}

$s1 = new Student("Ali Khan");
$s2 = new Student("Sara Ahmed");

unset($s1);     // destroys $s1 right now

echo "End of the script<br>";

?>