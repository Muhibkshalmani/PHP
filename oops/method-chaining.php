<?php

class Student {
    public $name;
    public $age;

    public function setName($n) {
        $this->name = $n;
        return $this;       // gives the same object back
    }

    public function setAge($a) {
        $this->age = $a;
        return $this;       // gives the same object back
    }

    public function show() {
        echo $this->name . " - " . $this->age;
    }
}

$s = new Student();

// without chaining: one call per line
$s->setName("Ali Khan");
$s->setAge(20);
$s->show();                 // Ali Khan - 20

echo "<br>";

// with chaining: all calls in one line
$s2 = new Student();
$s2->setName("Sara Ahmed")->setAge(19)->show();   // Sara Ahmed - 19

?>