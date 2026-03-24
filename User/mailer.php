<?php
$to = "arunps6520@gmail.com";
$subject = $_POST['subject'];
$message = "From: ".$_POST['name']."\nEmail: ".$_POST['email']."\n\n".$_POST['message'];
$headers = "From: ".$_POST['email'];

if(mail($to,$subject,$message,$headers)) {
    echo "200 OK";
} else {
    echo "500 Error";
}