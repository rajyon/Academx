<?php 
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}
date_default_timezone_set("Asia/Manila");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_choose.css" />
    <title>Select</title>
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
                <div>
                    <h1>Where do you belong?</h1>
                    <a href="verify.php?token=Student" class="card">
                        <span>Student</span> <br><br>
                        <img src="img/female-student.png" alt="Girl in a jacket" width="80%" height="80%">
                    </a> 
                    <a href="verify.php?token=Professional" class="card">
                        <span>Professional</span> <br><br>
                        <img src="img/businessman.png" alt="Girl in a jacket" width="80%" height="80%">
                    </a> 
                </div>
            
            </div>
        </div>
    </div>
    
</body>

</html>