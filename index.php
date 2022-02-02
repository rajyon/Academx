<?php

include 'config.php';
session_start();

error_reporting(0);
if (isset($_SESSION["user_id"])) {
  header("location: home.php");
}

if (isset($_POST["signup"])) {
  $firstName = mysqli_real_escape_string($conn, $_POST["regis_fname"]);
  $lastName = mysqli_real_escape_string($conn, $_POST["regis_lname"]);
  
  if(!empty($_POST['regis_sex'])) {
    $sex = mysqli_real_escape_string($conn, ($_POST["regis_sex"]));
} else {
    echo 'Please select the value.';
}
  $age = mysqli_real_escape_string($conn, ($_POST["regis_age"]));
  $email = mysqli_real_escape_string($conn, ($_POST["regis_email"]));
  $username = mysqli_real_escape_string($conn, ($_POST["regis_username"]));
  $password = mysqli_real_escape_string($conn, md5($_POST["regis_password"]));
  $cpassword = mysqli_real_escape_string($conn, md5($_POST["regis_cpassword"]));
  $contactNumber = mysqli_real_escape_string($conn, ($_POST["regis_contactnumber"]));
  $token =  mysqli_real_escape_string($conn, (md5(date("Y-m-d").$email)));

  $check_email = mysqli_num_rows(mysqli_query($conn, "SELECT email FROM amx_users_tbl WHERE email='$email'"));
  $check_username = mysqli_num_rows(mysqli_query($conn, "SELECT username FROM amx_users_tbl WHERE username='$username'"));
  

  if ($password !== $cpassword) {
    echo "<script>alert('Password did not match.');</script>";
  } elseif ($check_email > 0) {
    echo "<script>alert('Email already exists.');</script>";
  } else if($check_username>0){
    echo "<script>alert('Username already exists.');</script>";
  }
   else {
    
    $sql = "INSERT INTO amx_users_tbl (fname, lname, sex, age, email, username, password, contactnumber, token) 
            VALUES ('$firstName', '$lastName', '$sex', '$age', '$email', '$username','$password','$contactNumber','$token');
            INSERT INTO  amx_users_img SET profile_image='img/default.png',bio='No bio.', ID =(SELECT ID FROM amx_users_tbl WHERE email='$email');";
           
    $result = mysqli_multi_query($conn, $sql);
   
    if ($result) {
      $_POST["regis_fname"] = "";
      $_POST["regis_lname"] = "";
      $_POST["regis_sex"] = "";
      $_POST["regis_age"] = "";
      $_POST["regis_email"] = "";
      $_POST["regis_username"] = "";
      $_POST["regis_password"] = "";
      $_POST["regis_cpassword"] = "";
      $_POST["regis_contactnumber"] = "";
      echo "<script>alert('User registered.');</script>";
  }else{
      echo "<script>alert('User registration failed');</script>";
     
    }
  } 

}


if (isset($_POST["login"])) {
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $username = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = mysqli_real_escape_string($conn, md5($_POST["password"]));
  

  $check_email = mysqli_query($conn, "SELECT ID FROM amx_users_tbl WHERE password = '$password' AND email='$email'");
  $check_username = mysqli_query($conn, "SELECT ID FROM amx_users_tbl WHERE password = '$password' AND username= '$username'");
  $adminuser = 'admin';
  $adminpass = 'admin123';

  if (mysqli_num_rows($check_email) > 0 || mysqli_num_rows($check_username) > 0) 
  {
    if (mysqli_num_rows($check_email) > 0){
      $row = mysqli_fetch_assoc($check_email);
      $_SESSION["user_id"] = $row['ID'];
      header("Location: home.php");
    }else if(mysqli_num_rows($check_username) > 0){
      $row = mysqli_fetch_assoc($check_username);
      $_SESSION["user_id"] = $row['ID'];
      header("Location: home.php");
    } 
  } else {
    echo "<script>alert('Login details is incorrect. Please try again.');</script>";
  }
  if ($_POST["email"] == 'admin' && $_POST["password"] == 'admin123'){
    header("Location: adminhome.php");
  } 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style_index.css" />
  <link rel="icon" type="image/png" href ="img/tablogo.png">
  <title>AcadeMx</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" method="post" class="sign-in-form">
        <div style="margin-left: 140px; padding-bottom: 70px; width: 82%;">
        <img src="img/reallogo.png" class="image" alt="" />
        </div> 
        <h2 class="title">Log in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Enter Email Address Or Username" name="email" value="<?php echo $_POST['email']; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required />
          </div>
          <input type="submit" value="login" name="login" class="btn solid" />
          <p style="display: flex;justify-content: center;align-items: center;margin-top: 20px;"><a href="forgot-password.php" style="color: #4590ef;">Forgot Password?</a></p>
         
        </form>
         
        <!-- register -->
        <form action="" class="sign-up-form" method="post">
          <h2 class="title">Register</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="First Name" name="regis_fname" value="<?php echo $_POST["regis_fname"]; ?>" minlength="2" maxlenght = "15" required />
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Last Name" name="regis_lname" value="<?php echo $_POST["regis_lname"]; ?>" minlength="2" maxlenght = "15" required />
          </div>
          <div class="input-radio">
            <i class="fas fa-user" style= "margin-right: 10px; margin-left: 8px;"></i>
            <input type="radio" style= "margin-right: 5px; margin-left: 1px;" name="regis_sex" required value="Male" />Male
            <input type="radio" style= "margin-left: 40px; margin-right: 5px" name="regis_sex" required value="Female"/>Female
          </div>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="number" placeholder="Age" name="regis_age" value="<?php echo $_POST["regis_age"]; ?>" min="2" required />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email Address" name="regis_email" value="<?php echo $_POST["regis_email"]; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="text" placeholder="Username" name="regis_username" value="<?php echo $_POST["regis_username"]; ?>" minlength="4" maxlenght = "15" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="regis_password" value="<?php echo $_POST["regis_password"]; ?>"  minlength="5" maxlenght = "15"required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" name="regis_cpassword" value="<?php echo $_POST["regis_cpassword"]; ?>"  minlength="5" maxlenght = "15"required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="number" placeholder="Contact Number" name="regis_contactnumber" value="<?php echo $_POST["regis_contactnumber"]; ?>"  min="11" required />
          </div>
          <input type="submit" class="btn" name="signup" value="Sign up" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3 style ="margin-right:100px">New here ?</h3>
          <p style ="font-size: 19px;margin-right:100px">
            What are you waiting for? <br><br>Be a member of <span>Acade</span><span style="color: #5AC7C7;">Mx</span>
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Sign up 
          </button>
          
        </div>
        <img src="img/log.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3 style ="margin-right:100px">One of us?</h3>
          <p style ="font-size: 19px; margin-right:100px">
          Already one of us? Enter now!
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Login
          </button>
        </div>
        <img src="img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="app.js"></script>
</body>

</html>