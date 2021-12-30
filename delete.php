<?php
include 'config.php';

if(isset($_GET['token'])){
  $ID=$_GET['token'];
  $sql="DELETE FROM post_tbl WHERE post_id = '$ID';
         DELETE FROM comment_tbl WHERE post_id ='$ID'";
  $result = mysqli_multi_query($conn, $sql);
  if($result){
    header("location:myposts.php");
  }else{
      echo $conn->error;//getting the error
  }
}
else{
  header("location:myposts.php");//redirect
}

?>