<?php
// to move file from cleit side to server 

if(isset($_FILES['image'])){
$_filename = $_FILES['image']['name'];
$_filesize = $_FILES['image']['size'];
$_filetype = $_FILES['image']['type'];
$_filetemp_name = $_FILES['image']['tmp_name'];


move_uploaded_file($_filetemp_name, "uploaded-image/" . $_filename );

};

?>

<form action="" method="post" enctype="multipart/form-data">

<input type="file" name="image">
<input type="submit">


</form>