<?php 
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}
date_default_timezone_set("Asia/Manila");

$poster_ID = "";
$postID = "";
$likerID = $_SESSION['user_id'];
$liker = $_SESSION['Profile_Name'];
$notifContent = "$liker liked your post.";
if(isset($_GET['token'])){
    $postID = $_GET['token'];  
}
$sql = "SELECT * FROM post_tbl WHERE post_id ='$postID'";
$result = $conn->query($sql);
if (mysqli_num_rows($result)) {
$row = mysqli_fetch_assoc($result);
$poster_ID = $row['userid'];
}

$notifsql = "INSERT INTO notifications_tbl SET post_ID= '$postID', actor_ID = '$likerID', content = '$notifContent', action_type = 'like', poster_ID = '$poster_ID';";
$preselect = "SELECT * FROM likedislike_tbl WHERE liker_id = '$likerID' AND post_id = '$postID'";   
$PSresult = mysqli_query($conn, $preselect);

if(mysqli_num_rows($PSresult) > 0){
    $row=mysqli_fetch_assoc($PSresult);
    $typeReact = $row['typeReact'];
 
    if($typeReact == 'like'){
        $updateLike = "DELETE FROM likedislike_tbl WHERE liker_id = '$likerID' AND post_id = '$postID'";
        $ULresult = mysqli_query($conn, $updateLike);
        $selectUpdate1 = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult1 = mysqli_query($conn, $selectUpdate1);
        if(mysqli_num_rows($selectResult1) > 0){
            $row1=mysqli_fetch_assoc($selectResult1);
            $likeamount1=$row1['like_amount'];
            $likeamount1 = $likeamount1 - 1;
            $update_Like1 = "UPDATE post_tbl SET like_amount = '$likeamount1' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_Like1);
        }
    }else{
        $updatedisLikeToLike = "UPDATE likedislike_tbl SET typeReact = 'like' WHERE liker_id = '$likerID' AND post_ID = '$postID'";
        $ULTDresult = mysqli_query($conn, $updatedisLikeToLike);
        $selectUpdate = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult = mysqli_query($conn, $selectUpdate);
        if(mysqli_num_rows($selectResult) > 0){
            $row1=mysqli_fetch_assoc($selectResult);
            $dislikeamount1=$row1['dislike_amount'];
            $dislikeamount1 = $dislikeamount1 - 1;
            $likeamount1=$row1['like_amount'];
            $likeamount1 = $likeamount1 + 1;
            $update_Like1 = "UPDATE post_tbl SET like_amount = '$likeamount1', dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_Like1);
            if(!$conn->query($notifsql)){
                echo $conn->error;
               }
        }
    }

}else {
    $insertL = "INSERT INTO likedislike_tbl SET post_id = '$postID', liker_id = '$likerID', typeReact = 'like'";
    $resultiL = mysqli_query($conn, $insertL);
    $selectUpdate2 = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
    $selectResult2 = mysqli_query($conn, $selectUpdate2);

    if(mysqli_num_rows($selectResult2) > 0){
        $row2=mysqli_fetch_assoc($selectResult2);
        $likeamount2=$row2['like_amount'];
        $likeamount2++;
        $update_Like2 = "UPDATE post_tbl SET like_amount = '$likeamount2' WHERE post_id ='$postID'";
        mysqli_query($conn, $update_Like2);
        if(!$conn->query($notifsql)){
            echo $conn->error;
           }
    }
}




?>