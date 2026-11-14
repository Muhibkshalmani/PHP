<?php

// ----- Parent class -----
class Student {
    public $name;
    public $age;
    public $marks;

    // constructor: sets the name, age and marks
    function __construct($n, $a, $m) {
        $this->name = $n;
        $this->age = $a;
        $this->marks = $m;
    }

    // shows the student's details
    function info() {
        echo "<h3>Student Profile</h3>";
        echo "Student Name : " . $this->name . "<br>";
        echo "Student Age : " . $this->age . "<br>";
        echo "Student Marks : " . $this->marks . "<br>";
    }
}

// ----- Child class: "extends" means it gets everything from Student -----
class SportsStudent extends Student {
    // extra properties that only the child has
    public $sportsMarks = 10;
    public $bonusMarks = 5;
    public $totalMarks;

    // same method name as the parent, so this one replaces it for this class
    function info() {
        // add the extra marks to the normal marks
        $this->totalMarks = $this->marks + $this->sportsMarks + $this->bonusMarks;

        echo "<h3>Sports Student Profile</h3>";
        echo "Student Name : " . $this->name . "<br>";
        echo "Student Age : " . $this->age . "<br>";
        echo "Student Total Marks : " . $this->totalMarks . "<br>";
    }
}

// ----- Make a child object -----
$s1 = new SportsStudent("Ali Khan", 20, 70);
$s1->info();

// ----- Make a parent object -----
$s2 = new Student("Sara Ahmed", 19, 80);
$s2->info();


echo "<br>";

echo "<h4> Another examples of cars </h4> ";

echo "<br>";


// An another  example for better understanding 

// ----- Parent class: what every vehicle has -----
class Vehicle {
    public $brand;
    public $color;

    // constructor: sets the brand and color
    function __construct($b, $c) {
        $this->brand = $b;
        $this->color = $c;
    }

    // shows the details every vehicle has
    function info() {
        echo "Brand : " . $this->brand . "<br>";
        echo "Color : " . $this->color . "<br>";
    }

    // a method every vehicle can use
    function start() {
        echo $this->brand . " is starting...<br>";
    }
}

// ----- Child 1: Car adds doors -----
class Car extends Vehicle {
    public $doors = 4;

    // its own method, only cars have it
    function openTrunk() {
        echo "The trunk of the " . $this->brand . " is open.<br>";
    }
}

// ----- Child 2: Bike adds a different feature -----
class Bike extends Vehicle {
    public $hasBasket = true;

    // same name as the parent's method, so this replaces it for bikes
    function start() {
        echo $this->brand . " is starting with a kick!<br>";
    }
}


// ----- Car object -----
$car1 = new Car("Toyota", "White");
$car1->info();          // uses the parent's method
$car1->start();         // uses the parent's method
$car1->openTrunk();     // the car's own method
echo "Doors : " . $car1->doors . "<br><br>";

// ----- Bike object -----
$bike1 = new Bike("Honda", "Red");
$bike1->info();         // uses the parent's method
$bike1->start();        // the bike's own version


?>