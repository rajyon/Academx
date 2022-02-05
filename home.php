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
    $title = mysqli_real_escape_string($conn,$_POST['subject_post']);
    $post_type = $_POST['type'];
    $post_group = $_POST['group'];
    $content = mysqli_real_escape_string($conn,$_POST['content_post']);
    $date = date("Y-m-d  [h:i A]");

    if ($post_type == 'Public') {
        $picture = 'img/public.png';
    } else {
        $picture = 'img/org.png';
    }
    //Insertion to database      
    $sql = "INSERT INTO amx_post_tbl SET post_id='$PostId',userid='$userId',post_title='$title',post_type='$post_type', post_group = '$post_group', post_content='$content',post_date='$date',post_picture='$picture'";

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
$sql = "SELECT * FROM amx_group_transac WHERE member_ID = '$user'";

if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $item = $row['group_code'];
        $sql1 = "SELECT * FROM amx_group_tbl WHERE group_code = '$item'";
        $result2 = mysqli_query($conn, $sql1);
        $row1 = $result2->fetch_assoc();
        $item2 = $row1['group_name'];
        array_push($group_names, $item2);
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
    <link rel="icon" type="image/png" href ="img/AcadeMx.png">
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
                                array_push($group_list, $gname);
                            }
                            ?>
                        </select>
                        <textarea id="subject_post" minlength="4" maxlength="50" name="subject_post" placeholder="Subject or Title" rows="1" style="width:100%; display:block; " required></textarea>
                        <br>
                        <textarea id="content_post" minlength="4" maxlength="350" name="content_post" placeholder="What do you think?" rows="5" style="width:100%; display:block;" required></textarea>
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
                        <button name="filter" type="submit" class="fas fa-filter"></button>
                    </form>
                </div>
            </div>
            <br>

            <div class="row">
                <?php

                if ($to_filter == 'All') {
                    $display = "";
                    array_unshift($group_list, 'Public');

                    foreach ($group_list as $to_filter) {
                        $sql = "SELECT * FROM amx_post_tbl WHERE post_group = '$to_filter' ORDER BY post_date DESC; ";
                        $result = $conn->query($sql);
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $i++;
                            $ID = $row['post_id'];
                            $username = $row['userid'];
                            $query = "SELECT * FROM amx_users_tbl WHERE ID = '$username' LIMIT 1";
                            $results = mysqli_query($conn, $query);
                            $profileName = "";
                            if (mysqli_num_rows($results)) {
                                $row1 = mysqli_fetch_assoc($results);
                                $profileName = $row1['fname'] . ' ' . $row1['lname'];
                            }
                            $poster_name = $profileName;
                            $likebutton = '<button type="button" id = "like_button' . $i . '" name ="like_button' . $i . '" onclick="GetLike(this.value,this.id)" value=' . $ID . ' class ="fas fa-thumbs-up"   style="font-size:17px; margin-right: 15px; background-color: #ffffff; color: #3F3F3F; border: 1px solid #3F3F3F;border-radius: 5px;width: 110px;height: 40px;"><p id="button_txt">' . $row['like_amount'] . '</p></button>';
                            $dislikebutton = '<button type="button" id = "dislike_button' . $i . '" name ="dislike_button' . $i . '" onclick="GetDislike(this.value,this.id)" value=' . $ID . ' class ="fas fa-thumbs-down" style="font-size:17px; margin-right: 15px; background-color: #ffffff; color: #3F3F3F; border: 1px solid #3F3F3F;border-radius: 5px;width: 110px;height: 40px;""><p id="button_txt">' . $row['dislike_amount'] . '</p></button>';
                            $userId = $_SESSION['user_id'];
                            $sqlcheck = "SELECT * FROM amx_likedislike_tbl WHERE post_id = '$ID' AND liker_id = '$userId'";
                            $checkresult = mysqli_query($conn, $sqlcheck);
                            if (mysqli_num_rows($checkresult) > 0) {
                                $rowreaction = mysqli_fetch_assoc($checkresult);
                                $reactType = $rowreaction['typeReact'];
                                if ($reactType === 'like') {
                                    $likebutton = '<button type="button" id = "like_button' . $i . '" name ="like_button' . $i . '" onclick="GetLike(this.value,this.id)" value=' . $ID . ' class ="fas fa-thumbs-up"   style="font-size:17px; margin-right: 15px; background-color: #3F3F3F; color: white; border: 1px solid #ffffff;border-radius: 5px;width: 110px;height: 40px;"><p id="button_txt">' . $row['like_amount'] . '</p></button>';
                                } else {
                                    $dislikebutton = '<button type="button" id = "dislike_button' . $i . '" name ="dislike_button' . $i . '" onclick="GetDislike(this.value,this.id)" value=' . $ID . ' class ="fas fa-thumbs-down" style="font-size:17px; margin-right: 15px; background-color: #3F3F3F; color: white; border: 1px solid #ffffff;border-radius: 5px;width: 110px;height: 40px; "><p id="button_txt">' . $row['dislike_amount'] . '</p></button>';
                                }
                            }
                            $display .= '
                               <div class="column">
                                    <div class="card">
                                    <img src="' . $row['post_picture'] . '" alt="" style="width:100%">    
                                    <div class="container">
                                    <br>
                                        <h8 style ="color:gray; font-weight: bold;">Posted by: </h8>' . '
                                        <h9>' .  $poster_name . '<br>' . '
                                        <h8 style ="color:gray; font-weight: bold;">Date: </h8>
                                        <h9>' . $row['post_date'] . '<br>' . '
                                        <h8 style ="color:gray; font-weight: bold;">Post ID: </h8>' . '
                                        <h9>' . $row['post_id'] . '<br>' . '
                                        <hr style= "border-top: 5px solid #cccc;"></hr>
                                        <h2>' . $row['post_title'] . '</h2>
                                        <p style= "white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 350ch;">' . $row['post_content'] . '</p>
                                    </div>
                                    <form>
                                        <div class ="card_info">
                                        ' . $likebutton . '
                                        ' . $dislikebutton . '
                                        <a href="viewpost.php?token=' . $row['post_id'] . '" class = "card_link">View article</a>
                                        </form>
                                    </div>
                                    
                                    </div>
                            </div>';
                        }
                    }

                    echo $display;
                } else {
                    echo "<div class='alert alert-dark' style='text-align:center;font-size:16px;font-weight:bold'>$to_filter</div>";
                    $sql = "SELECT * FROM amx_post_tbl WHERE post_group = '$to_filter' ORDER BY post_date DESC ";
                    $result = $conn->query($sql);

                    $i = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $i++;
                        $ID = $row['post_id'];
                        $likebutton = '<button type="button" id = "like_button' . $i . '" name ="like_button' . $i . '" onclick="GetLike(this.value,this.id)" value=' . $ID . ' class ="fas fa-thumbs-up"   style="font-size:17px; margin-right: 15px; background-color: #ffffff; color: #3F3F3F; border: 1px solid #3F3F3F;border-radius: 5px;width: 110px;height: 40px;"><p id="button_txt">' . $row['like_amount'] . '</p></button>';
                        $dislikebutton = '<button type="button" id = "dislike_button' . $i . '" name ="dislike_button' . $i . '" onclick="GetDislike(this.value,this.id)" value=' . $ID . ' class ="fas fa-thumbs-down" style="font-size:17px; margin-right: 15px; background-color: #ffffff; color: #3F3F3F; border: 1px solid #3F3F3F;border-radius: 5px;width: 110px;height: 40px;""><p id="button_txt">' . $row['dislike_amount'] . '</p></button>';
                        $userId = $_SESSION['user_id'];
                        $sqlcheck = "SELECT * FROM amx_likedislike_tbl WHERE post_id = '$ID' AND liker_id = '$userId'";
                        $checkresult = mysqli_query($conn, $sqlcheck);
                        if (mysqli_num_rows($checkresult) > 0) {
                            $rowreaction = mysqli_fetch_assoc($checkresult);
                            $reactType = $rowreaction['typeReact'];
                            if ($reactType == 'like') {
                                $likebutton = '<button type="button" id = "like_button' . $i . '" name ="like_button' . $i . '" onclick="GetLike(this.value,this.id)" value=' . $ID . ' class ="fas fa-thumbs-up"   style="font-size:17px; margin-right: 15px; background-color: #3F3F3F; color: white; border: 1px solid #ffffff;border-radius: 5px;width: 110px;height: 40px;"><p id="button_txt">' . $row['like_amount'] . '</p></button>';
                            } else {
                                $dislikebutton = '<button type="button" id = "dislike_button' . $i . '" name ="dislike_button' . $i . '" onclick="GetDislike(this.value,this.id)" value=' . $ID . ' class ="fas fa-thumbs-down" style="font-size:17px; margin-right: 15px; background-color: #3F3F3F; color: white; border: 1px solid #ffffff;border-radius: 5px;width: 110px;height: 40px; "><p id="button_txt">' . $row['dislike_amount'] . '</p></button>';
                            }
                        }
                        echo '
                           <div class="column">
                                <div class="card">
                                <img src="' . $row['post_picture'] . '" alt="" style="width:100%">    
                                <div class="container">
                                <br>
                                    <h8 style ="color:gray; font-weight: bold;">Posted by: </h8>' . '
                                    <h9>' .  $poster_name . '<br>' . '
                                    <h8 style ="color:gray; font-weight: bold;">Date: </h8>
                                    <h9>' . $row['post_date'] . '<br>' . '
                                    <h8 style ="color:gray; font-weight: bold;">Post ID: </h8>' . '
                                    <h9>' . $row['post_id'] . '</h9>
                                    <hr style= "border-top: 5px solid #cccc;"></hr>
                                    <h2>' . $row['post_title'] . '</h2>
                                    <p style= "white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 350ch;">' . $row['post_content'] . '</p>
                                    </div>
                                    <form>
                                    <div class ="card_info">
                                    ' . $likebutton . '
                                    ' . $dislikebutton . '
                                    <a href="viewpost.php?token=' . $row['post_id'] . '" class = "card_link">View article</a>
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

<script>
    function GetLike(x, y) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if (document.getElementById(y).style.color === "rgb(63, 63, 63)") {
                document.getElementById(y).style = "font-size:17px; margin-right: 15px; background-color: #3F3F3F; color: white; border: 1px solid #ffffff;border-radius: 5px;width: 110px;height: 40px;";
                document.getElementById(y).querySelector("#button_txt").textContent = parseInt(document.getElementById(y).querySelector("#button_txt").textContent) + 1;
                   
                b="dis";
                b = b.concat(y)
                    if (document.getElementById(b).style.color === "white") {
                        document.getElementById(b).querySelector("#button_txt").textContent = parseInt(document.getElementById(b).querySelector("#button_txt").textContent) - 1;
                    }
                    document.getElementById(b).style = "font-size:17px; margin-right: 15px; background-color: #ffffff; color: #3F3F3F; border: 1px solid #3F3F3F;border-radius: 5px;width: 110px;height: 40px;";

            } else {
                document.getElementById(y).style = "font-size:17px; margin-right: 15px; background-color: #ffffff; color: #3F3F3F; border: 1px solid #3F3F3F;border-radius: 5px;width: 110px;height: 40px;";
                document.getElementById(y).querySelector("#button_txt").textContent = parseInt(document.getElementById(y).querySelector("#button_txt").textContent) - 1;
            }}
            xhttp.open("GET", "like.php?token=" + x);
            xhttp.send();
    }
    function GetDislike(x, y) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if (document.getElementById(y).style.color === "rgb(63, 63, 63)") {
                document.getElementById(y).style = "font-size:17px; margin-right: 15px; background-color: #3F3F3F; color: white; border: 1px solid #ffffff;border-radius: 5px;width: 110px;height: 40px;";
                document.getElementById(y).querySelector("#button_txt").textContent = parseInt(document.getElementById(y).querySelector("#button_txt").textContent) + 1;
                    
                b = y.slice(3);
                    if (document.getElementById(b).style.color === "white") {
                        document.getElementById(b).querySelector("#button_txt").textContent = parseInt(document.getElementById(b).querySelector("#button_txt").textContent) - 1;
                    }
                    document.getElementById(b).style = "font-size:17px; margin-right: 15px; background-color: #ffffff; color: #3F3F3F; border: 1px solid #3F3F3F;border-radius: 5px;width: 110px;height: 40px;";

            } else {
                document.getElementById(y).style = "font-size:17px; margin-right: 15px; background-color: #ffffff; color: #3F3F3F; border: 1px solid #3F3F3F;border-radius: 5px;width: 110px;height: 40px;";
                document.getElementById(y).querySelector("#button_txt").textContent = parseInt(document.getElementById(y).querySelector("#button_txt").textContent) - 1;
            }}
            xhttp.open("GET", "dislike.php?token=" + x);
            xhttp.send();
    }
</script>