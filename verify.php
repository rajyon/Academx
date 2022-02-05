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
                    <div class="card" id = "student_form">
                    <form>
                            <a href="select.php" id="back">Back</a>
                            <span style = "float:right"> 1 of 2 </span>
                        <br>
                             <h3> [Student] Please fill up the form: </h3>

                        <label for="txt_university">1. Where do you study? </label>
                        <input id="txt_university" type="text/css" placeholder="School/University"><br><br>
                        <label for="txt_course">2. What course are you taking? </label>
                        <input id="txt_course" type="text/css" placeholder="ex. Bachelor of Science in Information Techonology"><br><br>
                        <label for="txt_address">3. What is the address of your school/university? </label>
                        <input id="txt_address"  type="text/css" placeholder="School Address"><br><br>
                        <label for="txt_year">4. What year are you currently enrolled in? </label>
                        <input id="txt_year" type="text/css" placeholder="ex. 4th Year"> <br><br>
                        <button type = "button" id = "next" onclick = "Next()">Next</button>         
                    </form>
                </div>   
                
                <div id = "document" style = "display:none">
                    <script src="//code.jquery.com/jquery.min.js"></script>
                    <div id="nav-document">
                        <script>
                            $.get("document.php", function(data) {
                            $("#nav-document").replaceWith(data);
                         });
                        </script>
                    </div>
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
<script>
    function Next(){
        var x = document.getElementById("student_form");
        var y = document.getElementById("document");

        x.style.display = "none";
        y.style.display = "block";
    }
</script>