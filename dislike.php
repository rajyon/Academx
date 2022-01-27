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
$dislikerID = $_SESSION['user_id'];
$liker = $_SESSION['Profile_Name'];
$notifContent = "$liker disliked your post.";
if(isset($_GET['token'])){
    $postID = $_GET['token'];  
}
$sql = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID'";
$result = $conn->query($sql);
if (mysqli_num_rows($result)) {
$row = mysqli_fetch_assoc($result);
$poster_ID = $row['userid'];
}

$notifsql = "INSERT INTO amx_notifications_tbl SET post_ID= '$postID', actor_ID = '$dislikerID', content = '$notifContent', action_type = 'dislike', poster_ID = '$poster_ID', active = 1, action_time='$date';";
$preselect = "SELECT * FROM amx_likedislike_tbl WHERE liker_id = '$dislikerID' AND post_id = '$postID'";   
$PSresult = mysqli_query($conn, $preselect);

if(mysqli_num_rows($PSresult) > 0){
    $row=mysqli_fetch_assoc($PSresult);
    $typeReact = $row['typeReact'];
    if($typeReact == 'dislike'){
        $updatedisLike = "DELETE FROM amx_likedislike_tbl WHERE liker_id = '$dislikerID' AND post_id = '$postID'";
        $updateNotification = "DELETE FROM amx_notifications_tbl WHERE actor_ID = '$dislikerID' AND post_ID = '$postID' AND action_type ='dislike'";
        $ULresult = mysqli_query($conn, $updatedisLike);
        $UNresult = mysqli_query($conn, $updateNotification);
        $selectUpdate1 = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult1 = mysqli_query($conn, $selectUpdate1);
        if(mysqli_num_rows($selectResult1) > 0){
            $row1=mysqli_fetch_assoc($selectResult1);
            $dislikeamount1=$row1['dislike_amount'];
            $dislikeamount1 = $dislikeamount1 - 1;
            $update_disLike1 = "UPDATE amx_post_tbl SET dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_disLike1);
        }
    }else{
        $updateLikeTodisLike = "UPDATE amx_likedislike_tbl SET typeReact = 'dislike' WHERE liker_id = '$dislikerID' AND post_ID = '$postID'";
        $ULTDresult = mysqli_query($conn, $updateLikeTodisLike);
        $selectUpdate = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult = mysqli_query($conn, $selectUpdate);
        if(mysqli_num_rows($selectResult) > 0){
            $row1=mysqli_fetch_assoc($selectResult);
            $dislikeamount1=$row1['dislike_amount'];
            $dislikeamount1 = $dislikeamount1 + 1;
            $likeamount1=$row1['like_amount'];
            $likeamount1 = $likeamount1 - 1;
            $update_disLike1 = "UPDATE amx_post_tbl SET like_amount = '$likeamount1', dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_disLike1);
            if ($poster_ID != $dislikerID){
                if(!$conn->query($notifsql)){
                    echo $conn->error;
                   }
            } 
        }
    }

}else {
    $insertdL = "INSERT INTO amx_likedislike_tbl SET post_id = '$postID', liker_id = '$dislikerID', typeReact = 'dislike'";
    $resultiL = mysqli_query($conn, $insertdL);
    $selectUpdate2 = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
    $selectResult2 = mysqli_query($conn, $selectUpdate2);
    if(mysqli_num_rows($selectResult2) > 0){
        $row2=mysqli_fetch_assoc($selectResult2);
        $dislikeamount2=$row2['dislike_amount'];
        $dislikeamount2++;
        $update_disLike2 = "UPDATE amx_post_tbl SET dislike_amount = '$dislikeamount2' WHERE post_id ='$postID'";
        mysqli_query($conn, $update_disLike2);
        if ($poster_ID != $dislikerID){
            if(!$conn->query($notifsql)){
                echo $conn->error;
               }
        } 
    }
}

?>