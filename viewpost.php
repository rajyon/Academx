<?php
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}
date_default_timezone_set("Asia/Manila");
if(isset($_POST['post_button'])){
   
  $PostId=uniqid("#");
  $userId=$_SESSION['user_id'];
  $title=$_POST['subject_post'];
  $post_type=$_POST['type'];
  $content=$_POST['content_post'];
  $date= date("Y-m-d h:i:a");

if ($post_type =='Public'){
    $picture ='img/public.png';
}else
{
    $picture ='img/org.png';
}
//Insertion to database      
      $sql= "INSERT INTO post_tbl SET post_id='$PostId',userid='$userId',post_title='$title',post_type='$post_type',post_content='$content',post_date='$date',post_picture='$picture'";
        
            if(!$conn->query($sql))
            {
             echo $conn->error;//getting the error 
            }else{
                echo "<script>alert('Post Uploaded!');</script>";
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
    <link rel="stylesheet" href="style_home.css">
    <link rel="stylesheet" href="style_cards.css">
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
                    <textarea readonly id ="subject_post" name ="subject_post" rows ="1" style = "width:40%; display:inline-block;"required><?php echo $row1['post_title'];?> </textarea>
                    <textarea readonly id ="type" maxlength="50" name ="type" rows ="1" style = "width:20%; display:inline-block; border:none;"required>TYPE of POST:<?php echo $row1['post_type'];?></textarea>
                    <br>
                    <textarea readonly id ="content_post" name ="content_post" rows ="5" style ="width:100%; display:block;"required><?php echo $row1['post_content'];?></textarea>
                    <br>
                </form>
                <div>
              <img style ="width:5%; height:5%; border-radius:5px" src="<?php echo $profileImage2; ?>" class="profile_image" alt=""><h2 style="color: white; padding-left:10px; display: inline-block; vertical-align: bottom;"><?php echo $username1; ?></h2>
              </div>
              <br>
                <form  name="commentpost" method="post">
                    <br>
                    <textarea id ="content_post" name ="content_post" rows ="5" style ="width:100%; display:block;"required></textarea>
                    <br>
                </form>

              </div>
</div> 
</div>
</div>
</body>

</html>