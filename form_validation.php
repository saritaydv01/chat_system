<?php
include("dbcon.php");
// error_reporting(0);
$data = $_REQUEST;


if ($data['function'] == 'register') {
    $username = trim($data['username']);
    $rows = array();
    $query = "select uname from users where uname = '$username' ";
    $result = mysqli_query($conn, $query);
    while ($r = mysqli_fetch_assoc($result)) $rows[] = $r;

    if (count($rows) > 0) {
        echo "User exists. Choose another username!";
    } else {
        $query = "INSERT INTO `users`(`uname`, `pwd`, `full_name`, `bio`) VALUES ('" . $data['username'] . "' ,'" . $data['password'] . "' ,'" . $data['fullname'] . "' ,'" . $data['bio'] . "'  )";
        $result = mysqli_query($conn, $query);
        echo "1";
        // the redirection to login 
    }
    exit;
}

if ($data['function'] == 'login') {
    $query = "select uname, uid from users where pwd='" . $data['password'] . "' and uname='" . $data['uname'] . "' limit 1 ";
    $result = mysqli_query($conn, $query);
    while ($r = mysqli_fetch_assoc($result)) $rows[] = $r;

    if (count($rows) == 1) {
        echo "1";
        session_start();
    
        $_SESSION['username'] = $data['uname'];
        $_SESSION['session_id'] = $rows[0]['uid'];
       
    } else {
        echo "0";
    }
    
    exit;
}
