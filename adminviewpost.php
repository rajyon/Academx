<?php
require 'config.php';
session_start();

        
//like dislike
    if(isset($_POST['like_button'])){
        $date= date("F j, Y, g:i A");
        $poster_ID = "";
        $postId=$_GET['token'];
        $commenterId=$_SESSION['user_id'];
        $liker = $_SESSION['Profile_Name'];
        $notifContent = "$liker liked your post.";
        if(isset($_GET['token'])){
         $ID = $_GET['token'];
         $sql = "SELECT * FROM amx_post_tbl WHERE post_id = '$ID'";
         $result1 = $conn->query($sql);
         if(mysqli_num_rows($result1)>0){
            $row1 = mysqli_fetch_assoc($result1);
            $poster_ID = $row1['userid'];
         }
       
        }

        $notifsql = "INSERT INTO amx_notifications_tbl SET post_ID= '$postId', actor_ID = '$commenterId', content = '$notifContent', action_type = 'like', poster_ID = '$poster_ID', active = 1, action_time='$date'";

           
            $likerID = $_SESSION['user_id'];
            $postID = $_GET['token'];
            $preselect = "SELECT * FROM amx_likedislike_tbl WHERE liker_id = '$likerID' AND post_id = '$postID'";   
            $PSresult = mysqli_query($conn, $preselect);
            $color = "";
            
            if(mysqli_num_rows($PSresult) > 0){
                $row=mysqli_fetch_assoc($PSresult);
                $typeReact = $row['typeReact'];
                if($typeReact == 'like'){
                    $updateLike = "DELETE FROM amx_likedislike_tbl WHERE liker_id = '$likerID' AND post_id = '$postID'";
                    $ULresult = mysqli_query($conn, $updateLike);
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
                        if(!$conn->query($notifsql)){
                            echo $conn->error;
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
                    if(!$conn->query($notifsql)){
                        echo $conn->error;
                       }
                }
            }           
        }
        
        if(isset($_POST['dislike_button'])){
            $date= date("F j, Y, g:i A");
            $poster_ID = "";
            $postId=$_GET['token'];
            $commenterId=$_SESSION['user_id'];
            $liker = $_SESSION['Profile_Name'];
            $notifContent = "$liker disliked your post.";
            if(isset($_GET['token']))
           {
             $ID = $_GET['token'];
             $sql = "SELECT * FROM amx_post_tbl WHERE post_id = '$ID'";
             $result1 = $conn->query($sql);
             if(mysqli_num_rows($result1)>0){
                $row1 = mysqli_fetch_assoc($result1);
                $poster_ID = $row1['userid'];
             }
           
            }
    
            $notifsql = "INSERT INTO amx_notifications_tbl SET post_ID= '$postId', actor_ID = '$commenterId', content = '$notifContent', action_type = 'like', poster_ID = '$poster_ID', active = 1, action_time='$date'";
    

            $dislikerID = $_SESSION['user_id'];
            $postID = $_GET['token'];
            $preselect = "SELECT * FROM amx_likedislike_tbl WHERE liker_id = '$dislikerID' AND post_id = '$postID'";   
            $PSresult = mysqli_query($conn, $preselect);

            if(mysqli_num_rows($PSresult) > 0){
                $row=mysqli_fetch_assoc($PSresult);
                $typeReact = $row['typeReact'];
                if($typeReact == 'dislike'){
                    $updatedisLike = "DELETE FROM amx_likedislike_tbl WHERE liker_id = '$dislikerID' AND post_id = '$postID'";
                    $ULresult = mysqli_query($conn, $updatedisLike);
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
                        if(!$conn->query($notifsql)){
                            echo $conn->error;
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
                    if(!$conn->query($notifsql)){
                        echo $conn->error;
                       }
                }
            }
        
        }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link rel="stylesheet" href="style_viewpost.css"/>
    <link rel="icon" type="image/png" href ="img/tablogo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Home</title>
</head>

<body>

    <div>
        <script src="//code.jquery.com/jquery.min.js"></script>
        <div id="nav-placeholder">
            <script>
                $.get("adminhomepage.php", function(data) {
                    $("#nav-placeholder").replaceWith(data);
                });
            </script>
        </div>
    </div>
 
<div class="container-fluid" style="background-color: white;height:100vh">
<div class="contentx">

<!-- for display of picture, name, post id, post date, post type -->
<?php
$checker=0;
$gchecker='A';
$sqlx = "";
$post_group = "";
// $useID=$_SESSION['user_id'];

       if(isset($_GET['token']))
       {
         $ID = $_GET['token'];
         $sql = "SELECT * FROM amx_post_tbl WHERE post_id = '$ID'";
         $result1 = $conn->query($sql);
         if(mysqli_num_rows($result1)>0){
            $row1 = mysqli_fetch_assoc($result1);
            $post_group = $row1['post_group'];
            $poster_ID = $row1['userid'];
            $post_code = "";
            $presqlx = "SELECT * FROM amx_group_tbl WHERE group_name = '$post_group'";
            $preresult6 = mysqli_query($conn,$presqlx);
            if (mysqli_num_rows($preresult6)) {
                $prerow = mysqli_fetch_assoc($preresult6);
                $post_code = $prerow['group_code'];
            }
            // $sqlx = "SELECT * FROM group_transac WHERE member_ID = '$useID' AND group_code = '$post_code'";
            $idofuser = $row1['userid'];
            $query = "SELECT * FROM amx_users_img WHERE ID = '$idofuser' LIMIT 1";
            $results2 = mysqli_query($conn, $query);
            if (mysqli_num_rows($results2)) {
                $row2 = mysqli_fetch_assoc($results2);
                $profileImage = $row2['profile_image'];
            }
            $profileName = "";
            $query = "SELECT * FROM amx_users_tbl WHERE ID = '$idofuser' LIMIT 1";
            $results3 = mysqli_query($conn, $query);
       
            if (mysqli_num_rows($results3)) {
                $row3 = mysqli_fetch_assoc($results3);
                $profileName = $row3['fname'] . ' ' . $row3['lname'];
            }
            // $username1 = $_SESSION['user_id'];
            // $query = "SELECT * FROM users_tbl WHERE ID = '$username1' LIMIT 1";
            $results4 = mysqli_query($conn, $query);
       
            if (mysqli_num_rows($results4)) {
                $row4 = mysqli_fetch_assoc($results4);
                $username1 = $row4['fname'] . ' ' . $row4['lname'];
            }
            // $username2 = $_SESSION['user_id'];
            // $query = "SELECT * FROM users_img WHERE ID = '$username2' LIMIT 1";
            $results5 = mysqli_query($conn, $query);
            if (mysqli_num_rows($results5)) {
                $row5 = mysqli_fetch_assoc($results5);
                // $profileImage2 = $row5['profile_image'];
            }
            if($post_group!='Public'){
                $results6 = mysqli_query($conn, $sqlx);
            if(!mysqli_num_rows($results6)>0){
                $gchecker = 'B';
            }
            }

         }else{
            $checker++;
            echo "<div class='alert alert-danger'>Post not found!</div>";
         }
         
       }
?>
 

<div <?php if ($checker!=0){?>style="display:none"<?php }?> style = "min-height: 400px; flex:2.5; padding:20px;" >
              <div style = "border:solid thin #aaa; padding: 20px; background-color:#3F3F3F;">
              
              <div>
              <img style ="width:5%; height:5%; border-radius:5px" src="<?php echo $profileImage; ?>" class="profile_image" alt=""><h2 style="color: white; padding-left:10px; display: inline-block; vertical-align: bottom;"><?php echo $profileName; ?></h2>
              </div>
              <br>
                <form  name="frmInsertPost" method="post">
                    <textarea readonly id ="content_post" name ="content_post" rows ="11" style ="width:100%; display:block;"required>TITLE:                    <?php echo $row1['post_title'];?>&#13;&#10;TYPE OF POST:    <?php echo $row1['post_type'];?>&#13;&#10;POST ID:              <?php echo $row1['post_id'];?>&#13;&#10;DATE POSTED:    <?php echo $row1['post_date'];?>&#13;
__________________________________________________________________________________________________
                    <?php echo $row1['post_content'];?></textarea>
                    <br>
                    <div class = "wrapper">
                    <div class ="like">
                    <button disabled id = "like_button" name ="like_button" class ="fas fa-thumbs-up" style="font-size:17px; background-color: #<?php echo $newcolor; ?>; border-color: #<?php echo $forbordercolor; ?>; color: #<?php echo $fortextcolor; ?>;"><p><?php echo $row1['like_amount'] ?></p></button>
                    </div>
                    <div class ="dislike">
                        <button disabled id = "dislike_button" name ="dislike_button" class = "fas fa-thumbs-down" style="font-size:17px; background-color: #<?php echo $newcolor1; ?>; border-color: #<?php echo $forbordercolor1; ?>; color: #<?php echo $fortextcolor1; ?>;"><p><?php echo $row1['dislike_amount'] ?></p></button>
                    </div>
                    </div>
                </form>
              </div>
              <br>
                 
</div> 
</div>
</div>
</body>

</html>