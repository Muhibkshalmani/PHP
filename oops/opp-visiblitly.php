<?php

class Student {
    public $name = "Ali";       // public: usable anywhere
    protected $age = 20;        // protected: class + child classes only
    private $password = "1234"; // private: this class only

    // a public method can use all three, because it is inside the class
    public function show() {
        echo $this->name . " - " . $this->age . " - " . $this->password;
    }
}

$s1 = new Student();

echo $s1->name;        // works: public
// echo $s1->age;      // ERROR: protected
// echo $s1->password; // ERROR: private

$s1->show();           // works: the method is inside the class



echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";




// Another example 


// ----- Parent class -----
class Person {
    public $name = "Ali";           // public
    protected $city = "Peshawar";   // protected
    private $password = "1234";     // private

    // prints the private value (only code inside this class can read it)
    public function showPassword() {
        echo "Password : " . $this->password . "<br>";
    }
}

// ----- Child class -----
class Stud_ent extends Person {

    // prints the protected value (a child class can read it)
    public function showCity() {
        echo "City : " . $this->city . "<br>";
    }
}

$s1 = new Stud_ent();

// 1. public: print it directly from outside
echo "Name : " . $s1->name . "<br>";

// 2. protected: print it through the child class's method
$s1->showCity();

// 3. private: print it through the parent class's method
$s1->showPassword();





echo '<br>';



// ----- Example 1: echo INSIDE the class -----
class User1 {
    public $name;      // public
    private $pin;      // private

    function __construct($n, $p) {
        $this->name = $n;
        $this->pin = $p;
    }

    // the echo is inside the class
    public function show() {
        echo "Name : " . $this->name . "<br>";
        echo "Pin : " . $this->pin . "<br>";
    }
}

echo "<h3>Example 1: inside the class</h3>";
$u1 = new User1("Ali Khan", 1234);
$u1->show();


// ----- Example 2: echo OUTSIDE the class -----
class User2 {
    public $name;      // public
    private $pin;      // private

    function __construct($n, $p) {
        $this->name = $n;
        $this->pin = $p;
    }
}

echo "<h3>Example 2: outside the class</h3>";
$u2 = new User2("Sara Ahmed", 5678);

echo "Name : " . $u2->name . "<br>";   // works: public

// echo "Pin : " . $u2->pin;           // ERROR: private

?>