<?php

class Student {
    public $name = "Ali Khan";
    public $age = 20;
    public $password = "1234";

    // runs when serialize() is used: the password is left out
    public function __sleep() {
        return ["name", "age"];
    }

    // runs when unserialize() is used: we restore a value
    public function __wakeup() {
        echo "Object is waking up...<br>";
        $this->password = "default";
    }
}

$s = new Student();

$text = serialize($s);          // __sleep() runs, text is created

$s2 = unserialize($text);       // __wakeup() runs, object is rebuilt

echo $s2->name . "<br>";        // Ali Khan
echo $s2->age . "<br>";         // 20
echo $s2->password;             // default

?>