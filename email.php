<?php 
$to = "muhibk.shalmani@gmail.com";
$subject = "Test Email";
$message = "Hello, this is a testing email for testing the PHP mail function.";
$from = "test@gmail.com";
$headers = "From: $from";

if (mail($to, $subject, $message, $headers)) {
    echo "Yes, the PHP mail function is correct and the email for '$subject' has been sent successfully.";
} else {
    echo "Nope, the function is not correct or the email sending has been interrupted (Check your server's mail configuration).";
}
?>