<?php 
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}
date_default_timezone_set("Asia/Manila");
$date= date("F j, Y, g:i A");
$poster_ID = "";
$postID = "";
$likerID = $_SESSION['user_id'];
$liker = $_SESSION['Profile_Name'];
$notifContent = "$liker liked your post.";
if(isset($_GET['token'])){
    $postID = $_GET['token'];  
}
$sql = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID'";
$result = $conn->query($sql);
if (mysqli_num_rows($result)) {
$row = mysqli_fetch_assoc($result);
$poster_ID = $row['userid'];
}

$notifsql = "INSERT INTO amx_notifications_tbl SET post_ID= '$postID', actor_ID = '$likerID', content = '$notifContent', action_type = 'like', poster_ID = '$poster_ID', active = 1, action_time='$date';";
$preselect = "SELECT * FROM amx_likedislike_tbl WHERE liker_id = '$likerID' AND post_id = '$postID'";   
$PSresult = mysqli_query($conn, $preselect);

if(mysqli_num_rows($PSresult) > 0){
    $row=mysqli_fetch_assoc($PSresult);
    $typeReact = $row['typeReact'];
 
    if($typeReact == 'like'){
        $updateLike = "DELETE FROM amx_likedislike_tbl WHERE liker_id = '$likerID' AND post_id = '$postID'";
        $updateNotification = "DELETE FROM amx_notifications_tbl WHERE actor_ID = '$likerID' AND post_ID = '$postID'AND action_type ='like'";
        $updateNotification = "DELETE FROM amx_notifications_tbl WHERE actor_ID = '$dislikerID' AND post_ID = '$postID' AND action_type = 'dislike'";
        $ULresult = mysqli_query($conn, $updateLike);
        $UNresult = mysqli_query($conn, $updateNotification);
        $selectUpdate1 = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult1 = mysqli_query($conn, $selectUpdate1);
        if(mysqli_num_rows($selectResult1) > 0){
            $row1=mysqli_fetch_assoc($selectResult1);
            $likeamount1=$row1['like_amount'];
            $likeamount1 = $likeamount1 - 1;
            $update_Like1 = "UPDATE amx_post_tbl SET like_amount = '$likeamount1' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_Like1);
        }
    }else{
        $updatedisLikeToLike = "UPDATE amx_likedislike_tbl SET typeReact = 'like' WHERE liker_id = '$likerID' AND post_ID = '$postID'";
        $ULTDresult = mysqli_query($conn, $updatedisLikeToLike);
        $selectUpdate = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult = mysqli_query($conn, $selectUpdate);
        if(mysqli_num_rows($selectResult) > 0){
            $row1=mysqli_fetch_assoc($selectResult);
            $dislikeamount1=$row1['dislike_amount'];
            $dislikeamount1 = $dislikeamount1 - 1;
            $likeamount1=$row1['like_amount'];
            $likeamount1 = $likeamount1 + 1;
            $update_Like1 = "UPDATE amx_post_tbl SET like_amount = '$likeamount1', dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_Like1);
            if ($poster_ID != $likerID){
                if(!$conn->query($notifsql)){
                    echo $conn->error;
                   }
            }
        }
    }

}else {
    $insertL = "INSERT INTO amx_likedislike_tbl SET post_id = '$postID', liker_id = '$likerID', typeReact = 'like'";
    $resultiL = mysqli_query($conn, $insertL);
    $selectUpdate2 = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
    $selectResult2 = mysqli_query($conn, $selectUpdate2);

    if(mysqli_num_rows($selectResult2) > 0){
        $row2=mysqli_fetch_assoc($selectResult2);
        $likeamount2=$row2['like_amount'];
        $likeamount2++;
        $update_Like2 = "UPDATE amx_post_tbl SET like_amount = '$likeamount2' WHERE post_id ='$postID'";
        mysqli_query($conn, $update_Like2);
        if ($poster_ID != $likerID){
            if(!$conn->query($notifsql)){
                echo $conn->error;
               }
        } 
    }
}




?>