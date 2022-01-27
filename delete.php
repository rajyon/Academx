<?php
include 'config.php';

if(isset($_GET['token'])){
  $ID=$_GET['token'];
  $sql="DELETE FROM amx_post_tbl WHERE post_id = '$ID';
         DELETE FROM amx_comment_tbl WHERE post_id ='$ID';
         DELETE FROM amx_likedislike_tbl WHERE post_id ='$ID';
         DELETE FROM amx_notifications_tbl WHERE post_id = '$ID'";
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