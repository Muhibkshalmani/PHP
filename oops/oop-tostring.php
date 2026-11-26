<?php

class Student {
    public $name;
    public $age;

    public function __construct($n, $a) {
        $this->name = $n;
        $this->age = $a;
    }

    // runs when the object is used as text, like echo $s
    public function __toString() {
        return $this->name . " - " . $this->age;
    }
}

$s = new Student("Ali Khan", 20);

echo $s;    // Ali Khan - 20

?>