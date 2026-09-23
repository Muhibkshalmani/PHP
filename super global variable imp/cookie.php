<?php
// to save temporarly the information in website visitor system cookies super globale variable are used for that ..

$cookie_name = "users";
$cookie_value = "Mashaal";

setcookie($cookie_name,$cookie_value, time()+(3600*5),'/');

?>

<h2 style ="color:black ; text-align:center; ">

<?php
echo $_COOKIE[$cookie_name];

?>


</h2>