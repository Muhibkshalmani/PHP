<?php

class Student {

    // runs for a missing method called on an OBJECT: $s->something()
    public function __call($methodName, $arguments) {
        echo "__call: " . $methodName . "<br>";
    }

    // runs for a missing method called on the CLASS: Student::something()
    public static function __callStatic($methodName, $arguments) {
        echo "__callStatic: " . $methodName . "<br>";
    }
}

$s = new Student();
$s->study();           // __call: study

Student::study();      // __callStatic: study

?>