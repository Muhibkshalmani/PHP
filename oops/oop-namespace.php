<?php

namespace School {
    class User {
        public function hello() {
            echo "Hello from the School User<br>";
        }
    }
}

namespace Shop {
    class User {
        public function hello() {
            echo "Hello from the Shop User<br>";
        }
    }
}

namespace {
    // same class name "User", but each one is picked by its namespace
    $a = new \School\User();
    $a->hello();    // Hello from the School User

    $b = new \Shop\User();
    $b->hello();    // Hello from the Shop User
}

?>