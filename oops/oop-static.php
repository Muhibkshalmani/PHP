<?php

class Test {
    public static $name = "Ali";

    public static function hello() {
        echo "<br>Hello";
    }
}

echo Test::$name;    // Ali
Test::hello();       // Hello

?>

<!-- Here is another example of static  -->
 <?php

class Counter {
    public static $count = 0;      // static property

    public static function hello() {   // static method
        echo "Hello from a static method<br>";
    }

    public function add() {            // normal method
        self::$count++;                // static property inside the class: self::
    }
}

// no object needed for static members
echo Counter::$count . "<br>";         // 0
Counter::hello();                      // Hello from a static method

// normal methods still need an object
$c1 = new Counter();
$c1->add();

$c2 = new Counter();
$c2->add();

echo Counter::$count;                  // 2 (shared by all objects)

?>