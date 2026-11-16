<?php

// int $a, int $b: only whole numbers are allowed in
// : int : the function must return a whole number
function add(int $a, int $b): int {
    return $a + $b;
}

echo add(5, 3);        // 8

// echo add("hello", 3);   // ERROR: "hello" is not an int

echo "<br>";

?>

<?php

class Student {
    public string $name;     // typed property: must be a string

    // typed parameter and return type inside a class
    public function __construct(string $n) {
        $this->name = $n;
    }

    public function getName(): string {
        return $this->name;
    }
}

// a class name can be a type too: only a Student object is allowed in
function showStudent(Student $s) {
    echo $s->getName();
}

$s1 = new Student("Ali Khan");
showStudent($s1);          // Ali Khan

// showStudent("Ali");     // ERROR: "Ali" is not a Student object

?>