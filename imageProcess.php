<?php
include 'config.php';

$msg = "";
$css_class = "";

if(isset($_POST['save-user'])){
    $username = $_SESSION['user_id'];
    $profileImageName = $_FILES['profileImage']['name'];
    $bio = $_POST['bio'];
    $target = 'img/'.$profileImageName;
    $sql = "SELECT * FROM users_img WHERE ID = '$username' LIMIT 1";
    $results = mysqli_query($conn, $sql);  
    if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target))
    {
    $sql = "UPDATE users_img SET profile_image = '$target', bio ='$bio' WHERE ID = '$username'";
    if (mysqli_query($conn,$sql)){
        $msg = "Profile picture changed!";
        $css_class = "alert-success";
    } 
   }else{
        $msg = "Profile picture not changed!";
        $css_class = "alert-danger";
   }
}
?>