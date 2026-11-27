<?php

class Student {
    public $name = "Ali Khan";
    public $age = 20;
    public $password = "1234";

    // runs when serialize() is used
    public function __sleep() {
        // only name and age are saved, password is left out
        return ["name", "age"];
    }
}

$s = new Student();

$text = serialize($s);    // __sleep() runs here

echo $text;

?>