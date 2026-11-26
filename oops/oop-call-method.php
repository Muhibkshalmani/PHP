<?php

class Student {

    // runs when we call a method that doesn't exist in this class
    public function __call($methodName, $arguments) {
        echo "You called: " . $methodName . "<br>";
        echo "With values: " . implode(", ", $arguments) . "<br>";
    }

    public function hello() {
        echo "Hello, I am a real method<br>";
    }
}

$s = new Student();

$s->hello();                    // real method, runs normally

$s->study("PHP", "OOP");        // no study() method exists, so __call() runs

?>