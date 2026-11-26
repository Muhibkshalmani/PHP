<?php

class Student {
    private $age = 20;

    // runs when unset() is used on a private property
    public function __unset($property) {
        echo "You tried to unset: " . $property . "<br>";
        unset($this->$property);    // we allow the delete here
    }

    public function showAge() {
        if (isset($this->age)) {
            echo "Age is " . $this->age . "<br>";
        } else {
            echo "Age is not set<br>";
        }
    }
}

$s = new Student();
$s->showAge();       // Age is 20

unset($s->age);      // age is private, so __unset() runs

$s->showAge();       // Age is not set

?>