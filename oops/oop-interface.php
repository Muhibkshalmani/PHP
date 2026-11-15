<?php

// interface: only method names, no code inside
interface Payment {
   function pay($amount);
}

// each class MUST write pay(), in its own way
class Card implements Payment {
    public function pay($amount) {
        echo "Paid " . $amount . " by card<br>";
    }
}

class Cash implements Payment {
    public function pay($amount) {
        echo "Paid " . $amount . " in cash<br>";
    }
}

$c1 = new Card();
$c1->pay(500);      // Paid 500 by card

$c2 = new Cash();
$c2->pay(300);      // Paid 300 in cash

// $x = new Payment();   // ERROR: can't create an object from an interface

?>