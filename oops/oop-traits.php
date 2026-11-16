<?php

// trait: code written once
trait Hello {
    public function sayHello() {
        echo "Hello<br>";
    }
}

// both classes borrow it with "use"
class Student {
    use Hello;
}

class Teacher {
    use Hello;
}

$s = new Student();
$s->sayHello();    // Hello

$t = new Teacher();
$t->sayHello();    // Hello

?>