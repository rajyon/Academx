<?php 
include 'config.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
}
$userID = $_SESSION["user_id"];
$groupID = $_GET['token'];
$date = date("Y-m-d");

$sql = "INSERT INTO amx_group_transac SET group_code='$groupID', member_ID = '$userID', date_joined = '$date'";
$check = mysqli_query($conn,"SELECT * FROM amx_group_transac WHERE group_code = '$groupID' AND member_ID = '$userID'");


if(mysqli_num_rows($check) > 0){
    echo "<script>alert('You are already in this group!')
        window.location.href='group.php';
        </script> ";
}
else{
    $result = mysqli_query($conn,$sql);
    if($result){
        echo "<script>alert('Successfuly joined the group.')
        window.location.href='group.php';
        </script> ";
        
    }
    else{
        echo "<script>alert('There has been a problem!')
        window.location.href='group.php';
        </script> ";
    }
    
}


?>