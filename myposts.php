<?php
include 'config.php';
session_start();
  if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
  }
  $idofuser =$_SESSION["user_id"];
  
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
    <link rel="stylesheet" href="style_myposts.css"/>
    <link rel="stylesheet" href="style_cards2.css"/>
  
    <title>My Posts</title>
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
  
<h2 style="text-align:center; border-bottom: 2px solid red;">My Posts</h2>
            <br>  
            <div class="row">         
               <?php
                    $sql= "SELECT * FROM post_tbl WHERE userid ='$idofuser' ORDER BY post_date DESC";
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
                                <i class="fas fa-thumbs-up fa-xl"><span>Like</span></i>   
                                <i class="fas fa-thumbs-down fa-xl"><span>Dislike</span></i>
                                <a href="viewpost.php?token='.$row['post_id'].'" class ="card_link">View Article</a>
                                <a href="delete.php?token='. $row['post_id'] .'" class="card_link" > Delete </a>
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