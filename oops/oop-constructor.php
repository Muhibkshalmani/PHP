<?php
// Constructor: A special method named __construct() 
// that runs automatically when an object is created with new. It’s used to set the object’s starting values.


class person {
    // default values, used only if nothing else sets them
    public $name = "No Name";
    public $age = 0;

    // constructor: runs automatically when we write "new person(...)"
    function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }

    // a normal method that prints the details
    function show() {
        echo $this->name . " - " . $this->age;
    }
}

// make an object and pass the values straight away
$p1 = new person("Yahoo Baba", 20);

// the old way (no longer needed, the constructor does this for us)
// $p1->name = "Yahoo Baba";
// $p1->age = 20;

$p1->show();   // Yahoo Baba - 20


echo "<br>";

// An anothere example fo construct function


class Student {
    public $n;
    public $a;

    function __construct($name, $age) {
        $this->n = $name;
        $this->a = $age;
    }

    function show() {
        echo $this->n . " - " . $this->a;
    }
}

$s1 = new Student("Ali Khan", 20);
$s1->show();   // Ali Khan - 20


?>