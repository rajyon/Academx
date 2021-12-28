<?php
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}
date_default_timezone_set("Asia/Manila");

if(isset($_POST['commentpost_button'])){

  $postId=$_GET['token'];
  $commenterId=$_SESSION['user_id'];
  $date= date("Y-m-d h:i:a");
  $commentContent=$_POST['comment_post'];
  
//Insertion to database       
       $sql= "INSERT INTO comment_tbl (post_id, commenter_id, comment_date, comment_content) VALUES ('$postId', '$commenterId', '$date','$commentContent')";
            
            if(!$conn->query($sql))
            {
             echo $conn->error;//getting the error 
            }else{
                echo "<script>alert('Comment Uploaded!');</script>";
               
            }
        }
//like dislike
    if(isset($_POST['like_button'])){
           
        $postId=$_GET['token'];
        $sql = "SELECT * FROM post_tbl WHERE post_id ='$postId' LIMIT 1";
        $results = mysqli_query($conn, $sql);
              
        if($conn->query($sql))
                {
                $row=mysqli_fetch_assoc($results);
                $likeamount=$row['like_amount'];
                $likeamount++;
        $update_like="UPDATE post_tbl SET like_amount = '$likeamount' WHERE post_id ='$postId'";
        
        }
    }
        
        if(isset($_POST['dislike_button'])){
           
            $postId=$_GET['token'];
            $sql = "SELECT * FROM post_tbl WHERE post_id ='$postId' LIMIT 1";
            $results = mysqli_query($conn, $sql);
                  
            if($conn->query($sql))
                    {
                    $row=mysqli_fetch_assoc($results);
                    $dislikeamount=$row['dislike_amount'];
                    $dislikeamount++;
            $update_dislike="UPDATE post_tbl SET dislike_amount = '$dislikeamount' WHERE post_id ='$postId'";
            mysqli_query($conn, $update_dislike);
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

<!-- for display of picture, name, post id, post date, post type -->
<?php
       if(isset($_GET['token']))
       {
         $ID = $_GET['token'];
         $sql = "SELECT * FROM post_tbl WHERE post_id = '$ID'";
         $result1 = $conn->query($sql);
         $row1 = mysqli_fetch_assoc($result1);
       }
      $idofuser = $row1['userid'];
      $query = "SELECT * FROM users_img WHERE ID = '$idofuser' LIMIT 1";
      $results2 = mysqli_query($conn, $query);

      if (mysqli_num_rows($results2)) {
          $row2 = mysqli_fetch_assoc($results2);
          $profileImage = $row2['profile_image'];
      }
     $profileName = "";
     $query = "SELECT * FROM users_tbl WHERE ID = '$idofuser' LIMIT 1";
     $results3 = mysqli_query($conn, $query);

     if (mysqli_num_rows($results3)) {
         $row3 = mysqli_fetch_assoc($results3);
         $profileName = $row3['fname'] . ' ' . $row3['lname'];
     }
     $username1 = $_SESSION['user_id'];
     $query = "SELECT * FROM users_tbl WHERE ID = '$username1' LIMIT 1";
     $results4 = mysqli_query($conn, $query);

     if (mysqli_num_rows($results4)) {
         $row4 = mysqli_fetch_assoc($results4);
         $username1 = $row4['fname'] . ' ' . $row4['lname'];
     }
     $username2 = $_SESSION['user_id'];
     $query = "SELECT * FROM users_img WHERE ID = '$username2' LIMIT 1";
     $results5 = mysqli_query($conn, $query);
     if (mysqli_num_rows($results5)) {
         $row5 = mysqli_fetch_assoc($results5);
         $profileImage2 = $row5['profile_image'];
     }
     

?>
 

<div style = "min-height: 400px; flex:2.5; padding:20px;">
              <div style = "border:solid thin #aaa; padding: 20px; background-color:#3F3F3F;">
              
              <div>
              <img style ="width:5%; height:5%; border-radius:5px" src="<?php echo $profileImage; ?>" class="profile_image" alt=""><h2 style="color: white; padding-left:10px; display: inline-block; vertical-align: bottom;"><?php echo $profileName; ?></h2>
              </div>
              <br>
                <form  name="frmInsertPost" method="post">
                    <textarea readonly id ="content_post" name ="content_post" rows ="11" style ="width:100%; display:block;"required>TITLE:                   <?php echo $row1['post_title'];?>&#13;&#10;TYPE OF POST:   <?php echo $row1['post_type'];?>&#13;&#10;POST ID:               <?php echo $row1['post_id'];?>&#13;&#10;DATE POSTED:    <?php echo $row1['post_date'];?>&#13;&#10;
                    <?php echo $row1['post_content'];?></textarea>
                    <br>
                    <input id = "like_button" name= "like_button" type ="submit" value ="Like"/>
                    <input id = "dislike_button" name= "dislike_button" type ="submit" value ="Dislike"/>
                </form>
              </div>
              <br>
                  <h2 style="text-align:center; border-bottom: 2px solid red;">Comments Section</h2>
                  <div style = "border:solid thin #aaa; padding: 10px; padding-bottom:4px; background-color:none;">
                <div>
                    <h6 style="color: black; padding-left:10px; display: inline-block;">Commenting as: <?php echo $username1; ?></h6>
                </div>
                <form  name="comment_post" method="post">
                    <textarea maxlength="350" id ="comment_post" name ="comment_post" rows ="2" style ="width:100%; display:block;"required></textarea>
                    <div id = "text_area_remain">350 Characters Remaining</div>
                    
                    <script>
                        const myTextArea = document.getElementById('comment_post');
                        const remainingChars = document.getElementById('text_area_remain');
                        const MAX_CHARS = 350;

                        myTextArea.addEventListener('input', ()=> {
                            const remaining = MAX_CHARS - myTextArea.value.length;
                            const color = remaining < MAX_CHARS * 0.1 ? 'red' : null;
                            remainingChars.textContent = `${remaining} Characters Remaining`;
                            remainingChars.style.color = color;
                        });
                    </script>
                    <input id = "commentpost_button" name= "commentpost_button" type ="submit" value ="POST"/>

                </form>
                <br><br>   
                </div>
                <br>
            </div>
            <div style = "border:solid thin #aaa; padding: 10px; background-color:none;">
            <?php
                    $commenter_id = $_SESSION['user_id'];
                    $postId=$_GET['token'];
                    $query ="SELECT * FROM comment_tbl WHERE post_id = '$postId'";
                    $commentresult = mysqli_query($conn, $query);
    
                    while($row = mysqli_fetch_assoc($commentresult))
                    {
                        $username1 = $row['commenter_id'];
                        $nameofcommenter="";
                        $query2 = "SELECT * FROM users_tbl WHERE ID = '$username1' LIMIT 1";
                        $commentname = mysqli_query($conn, $query2);

                        if (mysqli_num_rows($commentname)) {
                            $row4 = mysqli_fetch_assoc($commentname);
                            $nameofcommenter = $row4['fname'] . ' ' . $row4['lname'];
                        }       
                    echo'
                    <div class="column"> 
                        <div style ="justify-content: space-between;">
                            <h6 style="color: black;  display: inline-block;"> '.$nameofcommenter.'</h6> 
                            <h6 style="color: black;  display: inline-block;"> '.$row['comment_date'].' </h6> 
                        </div>
                           <form  name="frmInsertPost" method="post">
                                <textarea readonly id ="comment_show" name ="comment_show" rows ="2" style ="color:black; width:100%; display:block;">'. $row['comment_content'].'</textarea>
                            </form>
                    </div>'; 
                    }
                ?> 
        <br>
</div> 
</div>
</div>
</body>

</html>