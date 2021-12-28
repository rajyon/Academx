<?php
include 'config.php';

if(isset($_GET['token'])){
  $ID=$_GET['token'];
  $sql="DELETE FROM post_tbl WHERE post_id = '$ID'";
  if($conn->query($sql)){
    
    header("location:myposts.php");
  }else{
      echo $conn->error;//getting the error
  }
}
else{
  header("location:Toledo_Luke_Inventory.php");//redirect
}

?>
