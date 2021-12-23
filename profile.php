<?php
session_start();
include 'config.php';
include 'imageProcess.php';
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
}
$table_data = "";

$FName = "";
$LName = "";
$Gender = "";
$Age = "";
$username = $_SESSION['user_id'];
$query = "SELECT * FROM users_tbl WHERE ID = '$username' LIMIT 1";
$results = mysqli_query($conn, $query);

if (mysqli_num_rows($results)) {
    $row = mysqli_fetch_assoc($results);
    $FName = $row['fname'];
    $LName = $row['lname'];
    $Sex = $row['sex'];
    $Age = $row['age'];

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style_editprofile.css">
    <title>Profile</title>
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
    <br>
    <div class="container-fluid" style="background-color: white;height:100vh">
        <div class="contentx">
            <table class="content-table" style="width:95%; ">
                <thead>
                    <tr style="background-color: #555; color: #fff;">
                        <th style="font-size: 17px;padding:15px">My Account</th>
                        <th style="font-size: 17px;padding:15px">Data</th>
                        <th style="font-size: 17px;padding:15px">Action</th>
                    </tr>
                    <tr style="background-color:#5AC7C7; color: black;">
                        <th colspan="3" style="padding:5px">Personal Information</th>
                    </tr>
                   
                    <tr>
                        <td>First Name</td>
                        <td><?php echo $FName ?></td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td><?php echo $LName ?></td>
                    </tr>
                    <tr>
                        <td>Sex</td>
                        <td><?php echo $Sex ?></td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td><?php echo $Age ?></td>
                    </tr>
                    <tr style="background-color: #5AC7C7; color: black;">
                        <th colspan="3" style="padding:5px">Profile Display</th>
                    </tr>
                    <tr>
                        <td>Profile Picture</td>
                    </tr>
                    <tr>
                        <td>Bio</td>
                    </tr>
                    <tr style="background-color: #5AC7C7; color: black;">
                        <th colspan="3" style="padding:5px">Contact Information</th>
                    </tr>
                    <td>Email Address</td>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                    </tr>
                    <tr style="background-color: #5AC7C7; color: black;">
                        <th colspan="3" style="padding:5px">Security and Verification</th>
                    </tr>
                    <tr>
                        <td>Username</td>
                    </tr>
                    <tr>
                        <td>Password</td>
                    </tr>
                    <tr>
                        <td>Varification Status</td>
                    </tr>

                    </tr>
                </thead>

                <?php

                echo  $table_data;

                ?>
        </div>
    </div>





</body>

</html>
<script>
    function triggerClick() {
        document.querySelector('#profileImage').click();
    }

    function displayImage(e) {
        if (e.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
            }

            reader.readAsDataURL(e.files[0]);
        }
    }
</script>