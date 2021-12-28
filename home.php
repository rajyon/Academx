<?php
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}
date_default_timezone_set("Asia/Manila");
if(isset($_POST['post_button'])){
   
  $PostId=uniqid("");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
    <link rel="stylesheet" href="style_home.css"/>
    <link rel="stylesheet" href="style_cards.css"/>
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
            
            <div style = "min-height: 400px; flex:2.5; padding:20px;">
              
            <div style = "border:solid thin #aaa; padding: 20px; background-color:#3F3F3F;">
            <form  name="frmInsertPost" method="post">
                <label for="postType" style = "margin-bottom:15px; color:white;">Type of Post</label>
                
                <select name="type" id="type">
                <option value="Public">Public</option>
                <option value="Organization Club">Organization/Club</option>
                </select>

                <textarea id ="subject_post" maxlength="50" name ="subject_post" placeholder="Subject or Title" rows ="1" style = "width:100%; display:block;" required ></textarea>
                <br>
                <textarea id ="content_post" maxlength="350" name ="content_post" placeholder="What do you think?" rows ="5" style ="width:100%; display:block;"required></textarea>
                <div id = "text_area_remain">350 Characters Remaining</div>
                    
                    <script>
                        const myTextArea = document.getElementById('content_post');
                        const remainingChars = document.getElementById('text_area_remain');
                        const MAX_CHARS = 350;

                        myTextArea.addEventListener('input', ()=> {
                            const remaining = MAX_CHARS - myTextArea.value.length;
                            const color = remaining < MAX_CHARS * 0.1 ? 'red' : null;
                            remainingChars.textContent = `${remaining} Characters Remaining`;
                            remainingChars.style.color = color;
                        });
                    </script>
        
                <input id = "post_button" name= "post_button" type ="submit" value ="POST"/>
                <br><br>
            </form>
            </div>
            </div>
            
            <h2 style="text-align:center; border-bottom: 2px solid red;">Posts</h2>
            <br>  
            <div class="row">
               <?php
                    $sql= "SELECT * FROM post_tbl ORDER BY post_date DESC";
                    $result = $conn->query($sql);
                    
                    while($row = mysqli_fetch_assoc($result))
                    {
                       echo'
                       <div class="column">
                            <div class="card">
                            <img src="'.$row['post_picture'].'" alt="" style="width:100%">    
                            <div class="container">
                            <br>
                                <h9>'.$row['post_date'].'<br>'.'Post ID'.'<h9>'.$row['post_id'].'</h9 >
                                <h2>'.$row['post_title'].'</h2>
                                <p style= "white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 350ch;">'.$row['post_content'].'</p>
                            </div>
                            <div class ="card_info">
                                <i class="fas fa-thumbs-up fa-xl">  Like</i>   
                                <i class="fas fa-thumbs-down fa-xl">  Dislike</i>
                                <a href="viewpost.php?token='.$row['post_id'].'" class ="card_link">View Article</a>
                            </div>
                            </div>
                    </div>'; 
                    }
                ?> 

                 
                    
            </div>
            
            
</div>
</div>
</body>

</html>