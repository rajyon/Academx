<?php
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: index.php");
}

date_default_timezone_set("Asia/Manila");
$selected = "";

if (isset($_GET['token'])) {
    $selected = $_GET['token'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_verify.css" />
    <title>Verify</title>
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
                <?php
                if ($selected == "Student") {
                    echo
                    '
                    <div class="card">
                    <div class="navigation">
                            <a href="select.php" id="back">Back</a>
                            <a href="select.php" id="next">Next</a>
                        </div><br><br>
                    <h3> [Student] Please fill up the form: </h3>
                    <form>
                        <label for="txt_university">1. Where do you study? </label>
                        <input id="txt_university" minlength="15" maxlength="100" type="text/css" placeholder="School/University"><br><br>
                        <label for="txt_university">2. What course are you taking? </label>
                        <input id="txt_university" minlength="15" maxlength="100" type="text/css" placeholder="ex. Bachelor of Science in Information Techonology"><br><br>
                        <label for="txt_university">3. What is the address of your school/university? </label>
                        <input id="txt_university" minlength="15" maxlength="100" type="text/css" placeholder="School Address">
    
                        
                        
                    </form>
                </div>            
                ';
                } else {
                    echo
                    '
                     <div class="card">
                    <h3> [Professional] Please fill up the form: </h3> 
                    <form></form>  
                    </div>             
                ';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>