<?php
// extract function convert array keys to variable 
// conpact function is used for converting varibales into array and it will reutrn an assosiative array.

$userSettings = [
    'theme' => 'dark',
    'notifications' => "onn",
    'fontSize' => 14
];



extract($userSettings);

echo "the theme color should be " . $theme . "<br>";

echo "Notification should be " . $notifications . "<br>";


$username = 'dev_guru';
$role = 'administrator';
$is_active = true;

$resultArray = compact('username', 'role', 'is_active');

echo "<pre>";
print_r($resultArray);
echo "</pre>";


?>