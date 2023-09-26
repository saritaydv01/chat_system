<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$database = "chatapplicationproject";

// Create a connection to the MySQL database
$conn = mysqli_connect($servername, $username, $password, $database);

//die if connection was not successful
if(!$conn) {
    die("Sorry we failed to connect: ". mysqli_connect_error());
}
else {
 echo "Successful";
}

?>