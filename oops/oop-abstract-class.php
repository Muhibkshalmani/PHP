<?php

// abstract class: can't be used with "new"
abstract class Shape {
    // abstract method: no body, every child MUST write it
    abstract public function area();
}

class Square extends Shape {
    public function area() {
        echo "Area : " . (5 * 5) . "<br>";
    }
}

class Rectangle extends Shape {
    public function area() {
        echo "Area : " . (4 * 6) . "<br>";
    }
}

$s = new Square();
$s->area();      // Area : 25

$r = new Rectangle();
$r->area();      // Area : 24

// $x = new Shape();   // ERROR: can't create an object from an abstract class

?>