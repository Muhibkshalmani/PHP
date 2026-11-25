<?php

class Student {
    private $age;       // private: can't be changed directly from outside

    // setter: changes the private value
    public function setAge($a) {
        if ($a > 0) {
            $this->age = $a;
        } else {
            echo "Age must be more than 0<br>";
        }
    }

    // getter: reads the private value
    public function getAge() {
        return $this->age;
    }
}

$s = new Student();

// $s->age = 20;         // ERROR: private

$s->setAge(20);          // works
echo $s->getAge();       // 20

$s->setAge(-5);          // Age must be more than 0
echo "<br>" . $s->getAge();   // 20 (the wrong value was rejected)

?>