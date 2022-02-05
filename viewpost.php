<?php
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}
date_default_timezone_set("Asia/Manila");

if (isset($_POST['commentpost_button'])) {
    $poster_ID = "";
    $date = date("F j, Y, g:i A");
    if (isset($_GET['token'])) {
        $ID = $_GET['token'];
        $sql = "SELECT * FROM amx_post_tbl WHERE post_id = '$ID'";
        $result1 = $conn->query($sql);
        if (mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $poster_ID = $row1['userid'];
        }
    }

    $postId = $_GET['token'];
    $commenterId = $_SESSION['user_id'];
    $commenter = $_SESSION['Profile_Name'];
    $date = date("Y-m-d h:i:a");
    $commentContent = mysqli_real_escape_string($conn, $_POST['comment_post']);
    $notifContent = "$commenter commented on your post.";

    //Insertion to database       
    $sql = "INSERT INTO amx_comment_tbl (post_id, commenter_id, comment_date, comment_content) VALUES ('$postId', '$commenterId', '$date','$commentContent')";
    $notifsql = "INSERT INTO amx_notifications_tbl SET post_ID= '$postId', actor_ID = '$commenterId', content = '$notifContent', action_type = 'comment', poster_ID = '$poster_ID', active = 1, action_time='$date';";

    if (!$conn->query($sql)) {
        echo $conn->error; //getting the error 
    } else {
        if ($poster_ID != $commenterId) {
            if (!$conn->query($notifsql)) {
                echo $conn->error;
            }
        }
    }
}

//like dislike
if (isset($_POST['like_button'])) {
    $date = date("F j, Y, g:i A");
    $poster_ID = "";
    $postId = $_GET['token'];
    $commenterId = $_SESSION['user_id'];
    $liker = $_SESSION['Profile_Name'];
    $notifContent = "$liker liked your post.";
    if (isset($_GET['token'])) {
        $ID = $_GET['token'];
        $sql = "SELECT * FROM amx_post_tbl WHERE post_id = '$ID'";
        $result1 = $conn->query($sql);
        if (mysqli_num_rows($result1) > 0) {
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

    if (mysqli_num_rows($PSresult) > 0) {
        $row = mysqli_fetch_assoc($PSresult);
        $typeReact = $row['typeReact'];
        if ($typeReact == 'like') {
            $updateLike = "DELETE FROM amx_likedislike_tbl WHERE liker_id = '$likerID' AND post_id = '$postID'";
            $updateNotification = "DELETE FROM amx_notifications_tbl WHERE actor_ID = '$likerID' AND post_ID = '$postID'AND action_type ='like'";
            $ULresult = mysqli_query($conn, $updateLike);
            $UNresult = mysqli_query($conn, $updateNotification);
            $selectUpdate1 = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
            $selectResult1 = mysqli_query($conn, $selectUpdate1);
            if (mysqli_num_rows($selectResult1) > 0) {
                $row1 = mysqli_fetch_assoc($selectResult1);
                $likeamount1 = $row1['like_amount'];
                $likeamount1 = $likeamount1 - 1;
                $update_Like1 = "UPDATE amx_post_tbl SET like_amount = '$likeamount1' WHERE post_id ='$postID'";
                mysqli_query($conn, $update_Like1);
            }
        } else {
            $updatedisLikeToLike = "UPDATE amx_likedislike_tbl SET typeReact = 'like' WHERE liker_id = '$likerID' AND post_ID = '$postID'";
            $ULTDresult = mysqli_query($conn, $updatedisLikeToLike);
            $selectUpdate = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
            $selectResult = mysqli_query($conn, $selectUpdate);
            if (mysqli_num_rows($selectResult) > 0) {
                $row1 = mysqli_fetch_assoc($selectResult);
                $dislikeamount1 = $row1['dislike_amount'];
                $dislikeamount1 = $dislikeamount1 - 1;
                $likeamount1 = $row1['like_amount'];
                $likeamount1 = $likeamount1 + 1;
                $update_Like1 = "UPDATE amx_post_tbl SET like_amount = '$likeamount1', dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
                mysqli_query($conn, $update_Like1);
                if ($poster_ID != $likerID) {
                    if (!$conn->query($notifsql)) {
                        echo $conn->error;
                    }
                }
            }
        }
    } else {
        $insertL = "INSERT INTO amx_likedislike_tbl SET post_id = '$postID', liker_id = '$likerID', typeReact = 'like'";
        $resultiL = mysqli_query($conn, $insertL);
        $selectUpdate2 = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult2 = mysqli_query($conn, $selectUpdate2);
        if (mysqli_num_rows($selectResult2) > 0) {
            $row2 = mysqli_fetch_assoc($selectResult2);
            $likeamount2 = $row2['like_amount'];
            $likeamount2++;
            $update_Like2 = "UPDATE amx_post_tbl SET like_amount = '$likeamount2' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_Like2);
            if ($poster_ID != $likerID) {
                if (!$conn->query($notifsql)) {
                    echo $conn->error;
                }
            }
        }
    }
}

if (isset($_POST['dislike_button'])) {
    $date = date("F j, Y, g:i A");
    $poster_ID = "";
    $postId = $_GET['token'];
    $commenterId = $_SESSION['user_id'];
    $liker = $_SESSION['Profile_Name'];
    $notifContent = "$liker disliked your post.";
    if (isset($_GET['token'])) {
        $ID = $_GET['token'];
        $sql = "SELECT * FROM amx_post_tbl WHERE post_id = '$ID'";
        $result1 = $conn->query($sql);
        if (mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $poster_ID = $row1['userid'];
        }
    }

    $notifsql = "INSERT INTO amx_notifications_tbl SET post_ID= '$postId', actor_ID = '$commenterId', content = '$notifContent', action_type = 'dislike', poster_ID = '$poster_ID', active = 1, action_time='$date'";


    $dislikerID = $_SESSION['user_id'];
    $postID = $_GET['token'];
    $preselect = "SELECT * FROM amx_likedislike_tbl WHERE liker_id = '$dislikerID' AND post_id = '$postID'";
    $PSresult = mysqli_query($conn, $preselect);

    if (mysqli_num_rows($PSresult) > 0) {
        $row = mysqli_fetch_assoc($PSresult);
        $typeReact = $row['typeReact'];
        if ($typeReact == 'dislike') {
            $updatedisLike = "DELETE FROM amx_likedislike_tbl WHERE liker_id = '$dislikerID' AND post_id = '$postID'";
            $updateNotification = "DELETE FROM amx_notifications_tbl WHERE actor_ID = '$dislikerID' AND post_ID = '$postID' AND action_type='dislike'";
            $ULresult = mysqli_query($conn, $updatedisLike);
            $UNresult = mysqli_query($conn, $updateNotification);
            $selectUpdate1 = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
            $selectResult1 = mysqli_query($conn, $selectUpdate1);
            if (mysqli_num_rows($selectResult1) > 0) {
                $row1 = mysqli_fetch_assoc($selectResult1);
                $dislikeamount1 = $row1['dislike_amount'];
                $dislikeamount1 = $dislikeamount1 - 1;
                $update_disLike1 = "UPDATE amx_post_tbl SET dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
                mysqli_query($conn, $update_disLike1);
            }
        } else {
            $updateLikeTodisLike = "UPDATE amx_likedislike_tbl SET typeReact = 'dislike' WHERE liker_id = '$dislikerID' AND post_ID = '$postID'";
            $ULTDresult = mysqli_query($conn, $updateLikeTodisLike);
            $selectUpdate = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
            $selectResult = mysqli_query($conn, $selectUpdate);
            if (mysqli_num_rows($selectResult) > 0) {
                $row1 = mysqli_fetch_assoc($selectResult);
                $dislikeamount1 = $row1['dislike_amount'];
                $dislikeamount1 = $dislikeamount1 + 1;
                $likeamount1 = $row1['like_amount'];
                $likeamount1 = $likeamount1 - 1;
                $update_disLike1 = "UPDATE amx_post_tbl SET like_amount = '$likeamount1', dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
                mysqli_query($conn, $update_disLike1);
                if ($poster_ID != $dislikerID) {
                    if (!$conn->query($notifsql)) {
                        echo $conn->error;
                    }
                }
            }
        }
    } else {
        $insertdL = "INSERT INTO amx_likedislike_tbl SET post_id = '$postID', liker_id = '$dislikerID', typeReact = 'dislike'";
        $resultiL = mysqli_query($conn, $insertdL);
        $selectUpdate2 = "SELECT * FROM amx_post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult2 = mysqli_query($conn, $selectUpdate2);

        if (mysqli_num_rows($selectResult2) > 0) {
            $row2 = mysqli_fetch_assoc($selectResult2);
            $dislikeamount2 = $row2['dislike_amount'];
            $dislikeamount2++;
            $update_disLike2 = "UPDATE amx_post_tbl SET dislike_amount = '$dislikeamount2' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_disLike2);
            if ($poster_ID != $dislikerID) {
                if (!$conn->query($notifsql)) {
                    echo $conn->error;
                }
            }
        }
    }
}
if(isset($_POST['SendReport']) ){
   if(isset($_POST['Reason'])){
    $content = $_POST['Reason'];
    $poster_ID = "";
    $postID = $_GET['token'];  
    $reporter = $_SESSION["user_id"];
    $reportdate = date("F j, Y, g:i A");

    if($content == "Others"){
        $content = $_POST['Others'];
    }
    

    if (isset($_GET['token'])) {
        $ID = $_GET['token'];
        $sql = "SELECT * FROM amx_post_tbl WHERE post_id = '$ID'";
        $result1 = $conn->query($sql);
        if (mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $poster_ID = $row1['userid'];
        }
    }
    $sqlReport = "INSERT INTO amx_report_tbl SET post_ID = '$postID', reason_content = '$content', reported_by = '$reporter', report_date = '$reportdate', poster_ID = '$poster_ID'";

    if (!$conn->query($sqlReport)) {
        echo $conn->error;
    }
    else{
        echo "<script>alert('Post has been reported successfully!');</script>";
    }
   }else{
    echo "<script>alert('Report filing has been canceled!, please enter a reason for your report.');</script>";
   }
  
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="style_viewpost.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="icon" type="image/png" href="img/tablogo.png">
    <title>View Post</title>
</head>

<body>
    <div>
        <script src="//code.jquery.com/jquery.min.js"></script>
        <div id="nav-placeholder">
            <script>
                $.get("homepage.php", function(data) {
                    $("#nav-placeholder").replaceWith(data);
                });
            </script>
        </div>
    </div>
    <div id="contentx1"></div>
    <div class="container-fluid" style="background-color: white;height:100vh" >
        <div class="contentx" id="contentx2">
      
            <!-- for display of picture, name, post id, post date, post type -->
            <?php
            $checker = 0;
            $gchecker = 'A';
            $sqlx = "";
            $post_group = "";
            $useID = $_SESSION['user_id'];

            if (isset($_GET['token'])) {
                $ID = $_GET['token'];
                $sql = "SELECT * FROM amx_post_tbl WHERE post_id = '$ID'";
                $result1 = $conn->query($sql);
                if (mysqli_num_rows($result1) > 0) {
                    $row1 = mysqli_fetch_assoc($result1);
                    $post_group = $row1['post_group'];
                    $poster_ID = $row1['userid'];
                    $post_code = "";
                    $presqlx = "SELECT * FROM amx_group_tbl WHERE group_name = '$post_group'";
                    $preresult6 = mysqli_query($conn, $presqlx);
                    if (mysqli_num_rows($preresult6)) {
                        $prerow = mysqli_fetch_assoc($preresult6);
                        $post_code = $prerow['group_code'];
                    }
                    $sqlx = "SELECT * FROM amx_group_transac WHERE member_ID = '$useID' AND group_code = '$post_code'";
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
                    $username1 = $_SESSION['user_id'];
                    $query = "SELECT * FROM amx_users_tbl WHERE ID = '$username1' LIMIT 1";
                    $results4 = mysqli_query($conn, $query);

                    if (mysqli_num_rows($results4)) {
                        $row4 = mysqli_fetch_assoc($results4);
                        $username1 = $row4['fname'] . ' ' . $row4['lname'];
                    }
                    $username2 = $_SESSION['user_id'];
                    $query = "SELECT * FROM amx_users_img WHERE ID = '$username2' LIMIT 1";
                    $results5 = mysqli_query($conn, $query);
                    if (mysqli_num_rows($results5)) {
                        $row5 = mysqli_fetch_assoc($results5);
                        $profileImage2 = $row5['profile_image'];
                    }
                    if ($post_group != 'Public') {
                        $results6 = mysqli_query($conn, $sqlx);
                        if (!mysqli_num_rows($results6) > 0) {
                            $gchecker = 'B';
                        }
                    }
                } else {
                    $checker++;
                    echo "<div class='alert alert-danger'>Post not found!</div>";
                }
            }
            ?>


            <div <?php if ($checker != 0) { ?>style="display:none" <?php } ?> style="min-height: 400px; flex:2.5; padding:20px;">
                <div style="border:solid thin #aaa; padding: 20px; background-color:#3F3F3F;">

                    <div>
                        <img style="width:5%; height:5%; border-radius:5px" src="<?php echo $profileImage; ?>" class="profile_image" alt="">
                        <h2 style="color: white; padding-left:10px; display: inline-block; vertical-align: bottom;"><?php echo $profileName; ?></h2>
                        <span style="color:#5AC7C7;font-weight: bold;float:right"><span style="-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;color:white;font-weight: bold;">#</span><?php echo $row1['post_id']; ?></span><br>
                        <span style="color:white;float:right;font-size:12px"><?php echo $row1['post_date']; ?></span>
                    </div>
                    <br>
                    <form name="frmInsertPost" method="post">
                        <div readonly id="content_post" name="content_post" rows="11" style="width:100%; display:block;background:white">
                            <div style="padding: 5px;background-color:#5AC7C7;font-weight: bold;">TITLE: <span style="color:white;font-weight: bold;"><?php echo $row1['post_title']; ?></span></br>
                                TYPE OF POST: <span style="color:white;"><?php echo $row1['post_type']; ?></span></br>
                            </div>
                            <div style="padding: 10px;word-wrap: break-word; white-space: pre-wrap; "><?php echo $row1['post_content']; ?></div>
                        </div>
                        <br>
                        <?php
                        $likerID = $_SESSION['user_id'];
                        $postID = $_GET['token'];
                        $reported = 0;

                        $selectionofreact = "SELECT * FROM amx_likedislike_tbl WHERE liker_id = '$likerID' AND post_id ='$postID'";
                        $ifReported = "SELECT * FROM amx_report_tbl WHERE reported_by = '$likerID' AND post_ID ='$postID'";
                        $SRresult = mysqli_query($conn, $selectionofreact);
                        $IRresult = mysqli_query($conn,  $ifReported);

                        if (mysqli_num_rows($SRresult)) {
                            $forcolorow = mysqli_fetch_assoc($SRresult);
                            $selectReaction = $forcolorow['typeReact'];
                            $newcolor = "";
                            $fortextcolor = "";
                            $forbordercolor = "";
                            if ($selectReaction == 'like') {
                                $newcolor = '3F3F3F';
                                $fortextcolor = "ffffff";
                                $forbordercolor = "ffffff";
                            } else {
                                $newcolor = 'ffffff';
                                $fortextcolor = "3F3F3F";
                                $forbordercolor = "3F3F3F";
                            }
                            if ($selectReaction == 'dislike') {
                                $newcolor1 = '3F3F3F';
                                $fortextcolor1 = "ffffff";
                                $forbordercolor1 = "ffffff";
                            } else {
                                $newcolor1 = 'ffffff';
                                $fortextcolor1 = "3F3F3F";
                                $forbordercolor1 = "3F3F3F";
                            }
                        }
                        if(mysqli_num_rows($IRresult)){
                            $reported = 1;  
                            $msg='<i class="fas fa-check-square"></i>&nbsp;   Reported';
                        }
                        else{
                            $msg='<i class="fas fa-times-square"></i>&nbsp;   Report';
                        }
                        ?>
                        
                        <button type="button" <?php if ($reported==1){?>style="font-size:17px;float:right; color:black;background-color:white" disabled <?php } ?> style="color:red;font-size:17px;float:right;width:100px;color:red" onclick="ContainerShow()"> <?php echo $msg; ?></button>
                        <div class="wrapper">
                            <div class="like">
                                <button id="like_button" name="like_button" class="fas fa-thumbs-up" style="font-size:17px; background-color: #<?php echo $newcolor; ?>; border-color: #<?php echo $forbordercolor; ?>; color: #<?php echo $fortextcolor; ?>;">
                                    <p><?php echo $row1['like_amount'] ?></p>
                                </button>
                            </div>
                            <div class="dislike">
                                <button id="dislike_button" name="dislike_button" class="fas fa-thumbs-down" style="font-size:17px; background-color: #<?php echo $newcolor1; ?>; border-color: #<?php echo $forbordercolor1; ?>; color: #<?php echo $fortextcolor1; ?>;">
                                    <p><?php echo $row1['dislike_amount'] ?></p>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                <br>
                <h2 style="text-align:center; border-bottom: 2px solid red;">Comment Section</h2>
                <div <?php if ($gchecker == 'B') { ?>style="display:none" <?php } ?> style="border:solid thin #aaa; padding: 10px; padding-bottom:4px; background-color:none;">
                    <div>
                        <h6 style="color: black; padding-left:10px; display: inline-block;">Commenting as: <?php echo $username1; ?></h6>
                    </div>
                    <form name="comment_post" method="post">
                        <textarea maxlength="350" id="comment_post" name="comment_post" rows="3" style="width:100%; display:block;" required></textarea>
                        <div id="text_area_remain">350 Characters Remaining</div>

                        <script>
                            const myTextArea = document.getElementById('comment_post');
                            const remainingChars = document.getElementById('text_area_remain');
                            const MAX_CHARS = 350;

                            myTextArea.addEventListener('input', () => {
                                const remaining = MAX_CHARS - myTextArea.value.length;
                                const color = remaining < MAX_CHARS * 0.1 ? 'red' : null;
                                remainingChars.textContent = `${remaining} Characters Remaining`;
                                remainingChars.style.color = color;
                            });
                        </script>
                        <input id="commentpost_button" name="commentpost_button" type="submit" value="POST" />
                    </form>
                    <br><br>
                </div>
                <br>
            </div>
            <div <?php if ($checker != 0 || $gchecker == 'B') {
                        echo 'style="display:none"';
                    } ?> style="border:solid thin #aaa; padding: 10px; background-color:none;">
                <?php
                $commenter_id = $_SESSION['user_id'];
                $postId = $_GET['token'];
                $query = "SELECT * FROM amx_comment_tbl WHERE post_id = '$postId'";
                $commentresult = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($commentresult)) {
                    $username1 = $row['commenter_id'];
                    $nameofcommenter = "";
                    $query2 = "SELECT * FROM amx_users_tbl WHERE ID = '$username1' LIMIT 1";
                    $commentname = mysqli_query($conn, $query2);

                    if (mysqli_num_rows($commentname)) {
                        $row4 = mysqli_fetch_assoc($commentname);
                        $nameofcommenter = $row4['fname'] . ' ' . $row4['lname'];
                    }
                    echo '
                    <div class="column"> 
                           <form  name="frmInsertPost" method="post">
                                <div readonly id ="comment_show" name ="comment_show" rows ="3" style ="color:black; width:100%; display:block;background:white;word-wrap: break-word;">
                                <span style="padding:5px;color: white;font-weight:bold; background:#5AC7C7;border-radius:5px;">' . $nameofcommenter . '</span><span style="color: #3F3F3F;font-size:12px;float:right;">[' . $row['comment_date'] . ']</span>
                                <span style="padding:5px;color: white; background:green;border-radius:5px;font-size:9px;line-height:30px">Student</span>
                                </br><span style="text-align: justify;white-space: pre-wrap;">↪&nbsp' . $row['comment_content'] . '<span></div>  
                            </form>
                    </div>';
                }

                ?>
                <br>
            </div>
        </div>
    </div>
    <div style="display:none" id="ReportContainer">
                <label style="background-color:#5AC7C7;width:100%;text-align:center;font-weight:bold;color:black">Report Post</label><br><br>
                <label>Post ID:     <span style="color:#5AC7C7;font-weight:bold"><?php echo  $postId; ?></span></label><br><br>
                <p>&nbsp;&nbsp;&nbsp;I would like to report this post because...</p>
                <label>Reason:</label><br>
                <form method="POST"> 
                    <input type="radio" style="font-size: 12px;height: 1rem;" id="Reason1" name="Reason" value="Language">
                    <label for="Reason1" >Language</label><br>
                    <input type="radio" style="font-size: 12px;height: 1rem;" id="Reason2" name="Reason" value="Spam">
                    <label for="Reason2">Spam</label><br>
                    <input type="radio" style="font-size: 12px;height: 1rem;" id="Reason3" name="Reason" value="False Information">
                    <label for="Reason3">False Information</label><br>
                    <input type="radio" style="font-size: 12px;height: 1rem;" id="Reason4" name="Reason" value="Hate Speech">
                    <label for="Reason4">Hate Speech</label><br>
                    <input type="radio" style="font-size: 12px;height: 1rem;" id="Reason5" name="Reason" value="Terrorism" onclick="Checked(this)">
                    <label for="Reason5">Terrorism</label><br><br>
                    <input type="radio" style="font-size: 12px;height: 1rem;" id="Reason6" name="Reason" value="Others" onclick="Checked(this)">
                    <label for="Reason6" id="Other">Other:</label><br>
                    <input type="text" maxlength="50" id="Others" name="Others" for="Reason6" placeholder="[Other Reason]" style="background-color: white;width:80%;padding:5px;float:right" disabled></input><br><br><br>
                    <input type="submit" value="Submit"style="float:left;width:100px;padding:1px;height:30px" name = "SendReport">
                    <input type="button" value="Cancel" style="float:right;width:100px;padding:1px;height:30px" onclick="ReportCancel()" id="example">
                </form>
            </div>

</body>

</html>
<script>
    function ContainerShow(){
        var x = document.getElementById("ReportContainer");
        var y = document.getElementById("contentx1");
        var z = document.getElementById("contentx2");

        x.style.width="500px";
        x.style.position="fixed";
        x.style.top="50%";
        x.style.left="50%";
        x.style.transform="translate(-50%, -50%)";
        x.style.backgroundColor="#3F3F3F";
        x.style.padding="5px";
        x.style.borderRadius="3px";
        x.style.border="solid 5px #5AC7C7";
        x.style.color="white";
        x.style.display="block";
        x.style.zIndex="1000";
        z.style.pointerEvents="none";
        y.style.display="block";
        y.style.width="100%";
        y.style.height="100%";
        y.style.position="fixed";
        y.style.zIndex="999";
        y.style.backgroundColor = "rgba(0,0,0,0.8)";
    }
    function ReportCancel(){
        var x = document.getElementById("ReportContainer");
        var y = document.getElementById("contentx1");
        var z = document.getElementById("contentx2");

        x.style.display = "none";
        y.style.display = "none";
        z.style.pointerEvents="auto";

    }
    function Checked(clicked){
        var x = document.getElementById("Reason6");
        var y = document.getElementById("Others");


        if(clicked.value == "Others"){
            y.removeAttribute("disabled");
            y.setAttribute("required",true);
        }else{
            y.setAttribute("disabled",true)
        }
        
    }
</script>