<?php
include('connection.php');
$msg = "";
if (isset($_GET['uname'])) {
    $uname = $_GET['uname'];
    $select = "SELECT * FROM user_login WHERE user_name = '$uname';";
    $result = mysqli_query($db, $select);

    if ($row = mysqli_fetch_array($result)) {
        $msg = 1;
    } else {
        $msg = 0;
    }
    echo $msg;
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $select = "SELECT * FROM user_login WHERE email = '$email';";
    $result = mysqli_query($db, $select);

    if ($row = mysqli_fetch_array($result)) {
        $msg = 1;
    } else {
        $msg = 0;
    }
    echo $msg;  
}
