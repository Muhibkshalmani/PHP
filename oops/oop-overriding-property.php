<?php

// ----- Parent class -----
class Animal {
    public $sound = "Some sound";    // property

    public function speak() {        // method
        echo "The animal says: " . $this->sound . "<br>";
    }
}

// ----- Child class -----
class Dog extends Animal {
    public $sound = "Woof";          // property override: same name as the parent's

    public function speak() {        // method override: same name as the parent's
        echo "The dog says: " . $this->sound . "<br>";
    }
}

$a = new Animal();
$a->speak();

$d = new Dog();
$d->speak();

?>