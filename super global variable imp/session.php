<?php
// session super global variable are use for to store temporaray information on server ...

session_start();

$_SESSION["users"] = "Mashal"

?>

<h1>
    <?php
    echo $_SESSION ["users"];
    ?>
</h1>