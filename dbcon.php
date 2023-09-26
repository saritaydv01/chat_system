<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "chat_system";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn){
die("Sorry we failed to connect: ". mysqli_connect_error());
}
?>