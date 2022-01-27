<?php 
include 'config.php';
if(isset($_GET['token']) && isset($_GET['change'])){
    $userID = $_GET['token'];
    $usernameChange = $_GET['change'];

    $checkUsername = "SELECT * FROM amx_users_tbl WHERE username = '$usernameChange'";
    $checkresult = mysqli_query($conn, $checkUsername);
    if(mysqli_num_rows($checkresult)>0){
        echo "Existing";
    }else{
        $updateUsername = "UPDATE amx_users_tbl SET username = '$usernameChange' WHERE ID = '$userID' ";
        $executeUpdate = mysqli_query($conn, $updateUsername);
        
        if($executeUpdate){
            echo "Success";
        }
    }
}
else{
    echo "error";
}

?>