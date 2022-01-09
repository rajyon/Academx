<?php
require 'config.php';
session_start();


if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}
date_default_timezone_set("Asia/Manila");
$to_filter = 'All';

if (isset($_POST['post_button'])) {

    $PostId = uniqid("");
    $userId = $_SESSION['user_id'];
    $title = $_POST['subject_post'];
    $post_type = $_POST['type'];
    $post_group = $_POST['group'];
    
    $content = $_POST['content_post'];
    $date = date("Y-m-d  [h:i A]");

    if ($post_type == 'Public') {
        $picture = 'img/public.png';
    } else {
        $picture = 'img/org.png';
    }
    //Insertion to database      
    $sql = "INSERT INTO post_tbl SET post_id='$PostId',userid='$userId',post_title='$title',post_type='$post_type', post_group = '$post_group', post_content='$content',post_date='$date',post_picture='$picture'";

    if (!$conn->query($sql)) {
        echo "<script>alert('Post Not Uploaded Please try again!!');</script>";
    } else {
        echo "<script>alert('Post Uploaded!');</script>";
        mysqli_query($conn, $sql);
    }
}

if (isset($_POST['filter'])) {
    $to_filter = $_POST['group_filter'];
}


$user = $_SESSION['user_id'];
$group_names = array();
$sql = "SELECT * FROM group_transac WHERE member_ID = '$user'";

if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $item = $row['group_code'];
        $sql1 = "SELECT * FROM group_tbl WHERE group_code = '$item'";
        $result2 = mysqli_query($conn, $sql1);
        $row1 = $result2->fetch_assoc();
        $item2 = $row1['group_name'];
        array_push($group_names, $item2);
    }
}
$like = null;
$dislike = null;

if(!empty($_POST)) {
    $array = $_POST;
    $array = array_reverse($array);
    $key = key($array); // get first key
    if(str_contains($key,'dislike')){
        $dislike = $key;
    }
    else{
        $like = $key;
    }
    
}
//like dislike
if(isset($_POST[$like])){
    $postID = "";
    if(isset($_GET['token'])){
        $postID = $_GET['token'];  
    }
    $sql = "SELECT * FROM post_tbl WHERE post_id ='$postID'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
}

    $likerID = $_SESSION['user_id'];

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
        }
    }

}

if(isset($_POST[$dislike])){
    $postID = "";
    if(isset($_GET['token'])){
        $postID = $_GET['token'];  
    }
    $sql = "SELECT * FROM post_tbl WHERE post_id ='$postID'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
}
    $dislikerID = $_SESSION['user_id'];
    $preselect = "SELECT * FROM likedislike_tbl WHERE liker_id = '$dislikerID' AND post_id = '$postID'";   
    $PSresult = mysqli_query($conn, $preselect);

    if(mysqli_num_rows($PSresult) > 0){
        $row=mysqli_fetch_assoc($PSresult);
        $typeReact = $row['typeReact'];
        if($typeReact == 'dislike'){
            $updatedisLike = "DELETE FROM likedislike_tbl WHERE liker_id = '$dislikerID' AND post_id = '$postID'";
            $ULresult = mysqli_query($conn, $updatedisLike);
            $selectUpdate1 = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
            $selectResult1 = mysqli_query($conn, $selectUpdate1);
            if(mysqli_num_rows($selectResult1) > 0){
                $row1=mysqli_fetch_assoc($selectResult1);
                $dislikeamount1=$row1['dislike_amount'];
                $dislikeamount1 = $dislikeamount1 - 1;
                $update_disLike1 = "UPDATE post_tbl SET dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
                mysqli_query($conn, $update_disLike1);
            }
        }else{
            $updateLikeTodisLike = "UPDATE likedislike_tbl SET typeReact = 'dislike' WHERE liker_id = '$dislikerID' AND post_ID = '$postID'";
            $ULTDresult = mysqli_query($conn, $updateLikeTodisLike);
            $selectUpdate = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
            $selectResult = mysqli_query($conn, $selectUpdate);
            if(mysqli_num_rows($selectResult) > 0){
                $row1=mysqli_fetch_assoc($selectResult);
                $dislikeamount1=$row1['dislike_amount'];
                $dislikeamount1 = $dislikeamount1 + 1;
                $likeamount1=$row1['like_amount'];
                $likeamount1 = $likeamount1 - 1;
                $update_disLike1 = "UPDATE post_tbl SET like_amount = '$likeamount1', dislike_amount = '$dislikeamount1' WHERE post_id ='$postID'";
                mysqli_query($conn, $update_disLike1);
            }
        }

    }else {
        $insertdL = "INSERT INTO likedislike_tbl SET post_id = '$postID', liker_id = '$dislikerID', typeReact = 'dislike'";
        $resultiL = mysqli_query($conn, $insertdL);
        $selectUpdate2 = "SELECT * FROM post_tbl WHERE post_id ='$postID' LIMIT 1";
        $selectResult2 = mysqli_query($conn, $selectUpdate2);

        if(mysqli_num_rows($selectResult2) > 0){
            $row2=mysqli_fetch_assoc($selectResult2);
            $dislikeamount2=$row2['dislike_amount'];
            $dislikeamount2++;
            $update_disLike2 = "UPDATE post_tbl SET dislike_amount = '$dislikeamount2' WHERE post_id ='$postID'";
            mysqli_query($conn, $update_disLike2);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="style_home.css" />
    <link rel="stylesheet" href="style_cards.css" />
    <link rel="stylesheet" href="style_search.css" />
    <title>Home</title>
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

    <div class="container-fluid" style="background-color: white;height:100vh">
        <div class="contentx">
            <div style="min-height: 400px; flex:2.5; padding:20px;">
                <div style="border:solid thin #aaa; padding: 20px; background-color:#3F3F3F;">
                    <form name="frmInsertPost" method="post">

                        <label for="postType" style="margin-bottom:15px; color:white;">Type of Post:</label>
                        <select name="type" id="type">
                            <option value="Public">Public</option>
                            <option value="Organization Club">Organization/Club</option>
                        </select>

                        <label for="group" style="margin-bottom:15px; color:white;">Group:</label>
                        <select name="group" id="group">
                            <option value="Public">Public</option>
                            <?php
                            $group_list = [];
                            foreach ($group_names as $gname) {
                                $selected = ($options == $gname) ? "selected" : "";
                                echo '<option ' . $selected . ' value="' . $gname . '">' . $gname . '</option>';
                                array_push($group_list,$gname);
                            }
                            ?>
                        </select>
                        <textarea id="subject_post" maxlength="50" name="subject_post" placeholder="Subject or Title" rows="1" style="width:100%; display:block; " required></textarea>
                        <br>
                        <textarea id="content_post" maxlength="350" name="content_post" placeholder="What do you think?" rows="5" style="width:100%; display:block;" required></textarea>
                        <div id="text_area_remain">350 Characters Remaining</div>

                        <script>
                            const myTextArea = document.getElementById('content_post');
                            const remainingChars = document.getElementById('text_area_remain');
                            const MAX_CHARS = 350;

                            myTextArea.addEventListener('input', () => {
                                const remaining = MAX_CHARS - myTextArea.value.length;
                                const color = remaining < MAX_CHARS * 0.1 ? 'red' : null;
                                remainingChars.textContent = `${remaining} Characters Remaining`;
                                remainingChars.style.color = color;
                            });
                        </script>

                        <input id="post_button" name="post_button" type="submit" value="POST" />
                        <br><br>
                    </form>
                </div>
            </div>

            <h2 style="text-align:center; border-top: 5px solid #5AC7C7; border-bottom: 5px solid #5AC7C7;  border-radius: 5px;">Posts</h2>
            <br>
            <div style=" display:flex; justify-content:space-between; border:2px solid #ccc!important; padding-right:5px">
            <div class="search-container">
                <form action="viewpost.php" method="get">
                    <input class="search" id="searchleft" type="search" name="token" placeholder="Search for Post ID" required>
                    <label class="button searchbutton" for="searchleft"><span class="mglass">&#9906;</span></label>
                </form>
            </div>
            <div style=" display: flex;align-items: center;justify-content: center;">
            <form name="frmFilter" method="post">
                <label for="group_filter" style=" color:black;">Filter:</label>
                <select name="group_filter" id="group_filter">
                    <option value="All">All</option>
                    <option value="Public">Public</option>
                    <?php
                    foreach ($group_names as $gname) {
                        echo '<option value="' . $gname . '"> ' . $gname . '</option>';
                    }
                    ?>
                </select>
                <button name="filter" type="submit" class="fas fa-filter" ></button>
            </form>
            </div>
            </div>
            <br>

            <div class="row">
                <?php
   
                if ($to_filter == 'All') {
                    $display = "";
                    array_unshift($group_list, 'Public');
              
                    foreach ($group_list as $to_filter){
                        $sql = "SELECT * FROM post_tbl WHERE post_group = '$to_filter' ORDER BY post_date DESC; ";
                        $result = $conn->query($sql);
                        $i=0;
             while ($row = mysqli_fetch_assoc($result)) {  
                 $i++;
                    $display .= '
                               <div class="column">
                                    <div class="card">
                                    <img src="' . $row['post_picture'] . '" alt="" style="width:100%">    
                                    <div class="container">
                                    <br>
                                        <h8 style ="color:gray; font-weight: bold;">Date: </h8>
                                        <h9>' . $row['post_date'] . '<br>' . '
                                        <h8 style ="color:gray; font-weight: bold;">Post ID: </h8>' . '
                                        <h9>' . $row['post_id'] . '<br>' . '
                                        <h8 style ="color:gray; font-weight: bold;">Posted by: </h8>' . '
                                        <hr style= "border-top: 5px solid #cccc;"></hr>
                                        <h2>' . $row['post_title'] . '</h2>
                                        <p style= "white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 350ch;">' . $row['post_content'] . '</p>
                                    </div>
                                    <form  action="?token='. $row['post_id'] .'" method="post">
                                        <div class ="card_info">
                                        <button id = "like_button" name ="like_button'.$i.'" class ="fas fa-thumbs-up" style="font-size:17px; margin-right: 15px; "><p>'.$row['like_amount'].'</p></button>
                                        <button id = "dislike_button" name ="dislike_button'.$i.'" class ="fas fa-thumbs-down" style="font-size:15px; "><p>'.$row['dislike_amount'].'</p></button>
                                        <button class="card_link"><a href="viewpost.php?token='. $row['post_id'] .'" class = "link">View article</a></button>
                                        </form>
                                    </div>
                                    
                                    </div>
                            </div>';
                        }
                    }  
                   
                    echo $display;     
                           
                } else {
                    echo "<div class='alert alert-dark' style='text-align:center;font-size:16px;font-weight:bold'>$to_filter</div>";
                    $sql = "SELECT * FROM post_tbl WHERE post_group = '$to_filter' ORDER BY post_date DESC ";
                    $result = $conn->query($sql);

                    $i=0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $i++;
                        echo '
                           <div class="column">
                                <div class="card">
                                <img src="' . $row['post_picture'] . '" alt="" style="width:100%">    
                                <div class="container">
                                <br>
                                    <h8 style ="color:gray; font-weight: bold;">Date: </h8>
                                    <h9>' . $row['post_date'] . '<br>' . '
                                    <h8 style ="color:gray; font-weight: bold;">Post ID: </h8>' . '
                                    <h9>' . $row['post_id'] . '</h9>
                                    <hr style= "border-top: 5px solid #cccc;"></hr>
                                    <h2>' . $row['post_title'] . '</h2>
                                    <p style= "white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 350ch;">' . $row['post_content'] . '</p>
                                    </div>
                                       <form  action="?token='. $row['post_id'] .'" method="post">
                                        <div class ="card_info">
                                        <button id = "like_button" name ="like_button'.$i.'"  id = "li" class ="fas fa-thumbs-up" style="font-size:17px; margin-right: 15px; "><p>'.$row['like_amount'].'</p></button>
                                        <button id = "dislike_button" name ="dislike_button'.$i.'"  id = "li" class ="fas fa-thumbs-down" style="font-size:15px; "><p>'.$row['dislike_amount'].'</p></button>
                                        <button class="card_link"><a href="viewpost.php?token='. $row['post_id'] .'" class = "link">View article</a></button>
                                        </form>
                                    </div>
                                </div>
                        </div>';
                    }
                }
             
                
                ?>
                
                

            </div>


        </div>
    </div>
</body>

</html>