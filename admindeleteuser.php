<?php
include 'config.php';

if(isset($_GET['token'])){
  $ID=$_GET['token'];
  $sql="DELETE FROM amx_users_tbl WHERE ID = '$ID';";
  $result = mysqli_multi_query($conn, $sql);
  if($result){
    header("location:adminusers.php");
  }else{
      echo $conn->error;//getting the error
  }
}
else{
  header("location:adminusers.php");//redirect
}

?>