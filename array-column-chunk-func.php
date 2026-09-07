<?php
//with the help of array column function we can get a specific key value from multidimensional array and it will return anew arrat
// array chunk function is used for making pair of values and it will make a multidiemensional array of that values 



$users_data = [
    [
        'id' => 1,
        'name' => 'Alice',
        'email' => 'alice@example.com',
        'status' => 'active'
    ],
    [
        'id' => 2,
        'name' => 'Bob',
        'email' => 'bob@example.com',
        'status' => 'pending'
    ],
    [
        'id' => 3,
        'name' => 'Charlie',
        'email' => 'charlie@example.com',
        'status' => 'active'
    ],
    [
        'id' => 4,
        'name' => 'Diana',
        'email' => 'diana@example.com',
        'status' => 'inactive'
    ]
];

$Name = array_column($users_data,'name');

echo "<pre>";
print_r($Name);
echo "</pre>";





$permissions = [
    'read_posts',
    'write_posts',
    'delete_posts',
    'publish_posts',
    'manage_users',
    'view_reports'
];

// array chuck function 

$chunkfunc = array_chunk($permissions,2);

echo "<br>";
echo "<pre>";
print_r($chunkfunc);
echo "</pre>";


 

?>