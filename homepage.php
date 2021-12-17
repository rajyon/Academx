<?php
include 'config.php';


session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href ="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href = "style_homepage.css">
    <title>Homepage</title>
</head>
<body>
    <input type = "checkbox" id="check">
   <header>
       <label for ="check">
        <i class = "fas fa-bars" id = "sidebar_btn"></i>
       </label>
       <div class = "left_area">
           <h3>Acade<span>Mx</span></h3>
       </div>
   </header>
        <div class = "sidebar">
            <center>
            <?php
                    $username = $_SESSION['user_id'];
                    $query = "SELECT * FROM users_img WHERE ID = '$username' LIMIT 1";
                    $results = mysqli_query($conn, $query);
    
                    if(mysqli_num_rows($results))
                    {
                    $row = mysqli_fetch_assoc($results);
                    $profileImage = $row['profile_image'];
                    }
                ?>
            <img src="<?php echo $profileImage; ?>" class = "profile_image" alt="">
                <?php
                                      $profileName = "";
                                      $username = $_SESSION['user_id'];
                                      $query = "SELECT * FROM users_tbl WHERE ID = '$username' LIMIT 1";
                                      $results = mysqli_query($conn, $query);
                        
                                        if(mysqli_num_rows($results))
                                        {
                                        $row = mysqli_fetch_assoc($results);
                                        $profileName = $row['fname'].$row['lname'];
                                        }
                ?>
                <h4><?php echo $profileName;?></h4>
            </center> 
            <a href = "homepage.php"><i class="fas fa-home"></i><span>Home</span></a>
            <a href = "editprofile.php"><i class="far fa-address-card"></i><span>Profile</span></a>
            <a href = "#"><i class="far fa-sticky-note"></i><span>My Posts</span></a>
            <a href = "#"><i class="fas fa-info-circle"></i><span>About Us</span></a>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <a href = "#"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </div>
        <div class="content"></div>
</body>
</html>