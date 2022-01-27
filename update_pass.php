<?php 
require 'config.php';

$ID = $_GET['token'];
$NewPass = md5($_GET['pass']);

$checkpass = "SELECT * FROM amx_users_tbl WHERE ID = '$ID'";
$checkresult = mysqli_query($conn,$checkpass);
$row = mysqli_fetch_assoc($checkresult);
$Oldpass = $row['password'];

if($Oldpass == $NewPass){
    echo '1';
}else{
    $updatepass = "UPDATE amx_users_tbl SET password = '$NewPass' WHERE ID = '$ID'";
    $updateresult = mysqli_query($conn, $updatepass);
    if ($updateresult) {
        echo '2';
}
}

?>