<?php

class Student {
    public $name = "Ali Khan";
    private $age = 20;

    // runs when isset() is used on an inaccessible property
    public function __isset($property) {
        echo "isset() was used on: " . $property . "<br>";
        return isset($this->$property);    // true if it really exists
    }
}

$s = new Student();

var_dump(isset($s->name));    // bool(true)   public, so __isset() is NOT used

var_dump(isset($s->age));     // runs __isset(), then bool(true)

var_dump(isset($s->city));    // runs __isset(), then bool(false)

?>