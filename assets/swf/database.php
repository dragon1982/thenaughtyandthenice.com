<?php
$host       = "localhost";
$database   = "database";
$user       = "username";
$pass       = "password";
$db = mysqli_connect($host,$user,$pass,$database) or die(mysqli_error());
?>