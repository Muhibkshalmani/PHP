<?php

class Student {
    private $name;       // private: can't be read directly from outside

    public function __construct($n) {
        $this->name = $n;
    }

    // getter: returns the private value
    public function getName() {
        return $this->name;
    }
}

$s = new Student("Ali Khan");

// echo $s->name;        // ERROR: private

echo $s->getName();      // Ali Khan

?>