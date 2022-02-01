<?php
include 'config.php';


session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="style_homepage.css" />
    <link rel="stylesheet" href="style_admin.css" />
    <title>Homepage</title>
</head>

<body>
    <div class="master">
        <header>
            <div class="left_area1">
                <h3>Acade<span>Mx</span></h3>
            </div>
        </header>
        <div class="sidebar">
            <center>
                <?php
                ?>
                <img src="img/default.png" class="profile_image" alt="">
                <h4>admin</h4>
            </center>
            <a href="adminhome.php"><i class="fas fa-home"></i><span>Posts</span></a>
            <a href="adminusers.php"><i class="fas fa-home"></i><span>Users</span></a>
            <div style="vertical-align: sub;">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
            </div>

        </div>
    </div>

</body>

</html>