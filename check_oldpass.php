<?php 
require 'config.php';

$ID = $_GET['token'];
$OldPass = md5($_GET['old']);

$checkpass = "SELECT password FROM amx_users_tbl WHERE ID = '$ID' AND password = '$OldPass'";
$checkresult = mysqli_query($conn,$checkpass);

if(mysqli_num_rows($checkresult)){
    echo '1';
}
else{
    echo '2';
}
?>