<?php
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}
date_default_timezone_set("Asia/Manila");

if(isset($_POST['commentpost_button'])){

  $postId=$_SESSION['post_id'];
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
                mysqli_query($conn,$sql);
               
            }
        }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="style_viewpost.css">
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
                    <?php echo $row1['post_content'];?>&#13;&#10;&#13;&#10;POSTED BY: <?php echo $profileName; ?></textarea>
                    <br>
                </form>
              </div>
              <br>
                  <h2 style="text-align:center; border-bottom: 2px solid red;">Comments Section</h2>
               <div>
                <h6 style="color: black; padding-left:10px; display: inline-block;">Commenting as: <?php echo $username1; ?></h6>
              </div>
                <form  name="comment_post" method="post">
                    <textarea maxlength="350" id ="comment_post" name ="comment_post" rows ="3" style ="width:100%; display:block;"required></textarea>
                </form>
        
                <input id = "commentpost_button" name= "commentpost_button" type ="submit" value ="POST"/>
            <br>
</div> 
</div>
</div>
</body>

</html>