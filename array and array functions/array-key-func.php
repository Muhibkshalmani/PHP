<?php
// array key functions 

$company =["Awais","junaid","fawad","zee"];

$ar_key = array_keys($company);

echo "<pre>";

print_r($ar_key);
echo "</pre>";

echo "<br>";

$memberProfile = [
    'user_id' => 4821,
    'first_name' => 'Marcus',
    'last_name' => 'Brooke',
    'email' => 'marcus.brooke@example.com',
    'membership_id' => 3,
    'status' => 'active',
    'created_at' => '2025-11-20 08:30:00',
    'preferences' => [
        'newsletter' => true,
        'theme' => 'dark',
        'notifications' => ['email', 'sms']
    ]
];

$profile = array_key_first($memberProfile);
echo "<pre>";
print_r($profile);
echo "</pre>";

$profile = array_key_last($memberProfile);
echo "<pre>";
print_r($profile);
echo "</pre>";

if ($profile = key_exists("status",$memberProfile)){
    echo "yes the key is there ";
}else{
    echo "nope the key is not there you are looking for a wrong key";
}

echo "<br>";


if ($profile = key_exists("name",$memberProfile)){
    echo "yes the key is there ";
}else{
    echo "nope the key is not there you are looking for a wrong key";
}




?>