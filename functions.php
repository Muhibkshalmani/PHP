<?php
// // functions is used for a specific purpose when we want to display a specific code many time in site then we put them in a function and then call the fucntion there where we need
function hello(){
    echo "Welcome to the site <br>";
}

hello();
hello();
hello();



// // function with returning value

function name ($fname, $lname){

$fullname = "$fname  $lname";
return $fullname ;

}
echo name("Muhib","jaan" . "<br>");
echo name("Muhib","jaan" . "<br>");
echo name("Muhib","jaan" . "<br>");
echo name("Muhib","jaan" . "<br>");


//  how to pass or put php function arguments as  a refference 


function prof(&$porfession){
$porfession .= "  yes there is me";

}

$rank =  " Hello this is mubi and Iam a  web designer and now learning php";
 prof( $rank);

echo $rank;


?>