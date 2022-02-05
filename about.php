<?php
session_start();
  if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
  }?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style_about.css">
    <link rel="icon" type="image/png" href ="img/tablogo.png">
    <title>About Us</title>
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

    <div class="container-fluid" style="background-color: white;height:100vh;">
<div class="contentx">
<div class="about-section">
  <h1 style = "font-weight: 900;">ACADE<span>MX</span></h1><br>
  <div class="row">
  <div class="box">
  <h3 style="color: #5AC7C7;">MISSION</h3>
  To empower and give the student, alumni, organization, and university achieve more and give power to share and make the university more open and connected. 
  </div>
  <div class="box">
  <h3 style="color: #5AC7C7;">VISION</h3>
  AcadeMx sets the standards to create a transformative educational experience for students and alumuni focused on deep disciplinary knowledge; problem solving; leadership, communication, and interpersonal skills; and personal health and well-being.
  </div>
  </div>
</div>
<br>
<h2 style="text-align:center; border-top: 5px solid #5AC7C7; border-bottom: 5px solid #5AC7C7;  border-radius: 5px;">Our Team</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="img/marvin.png" alt="Jane" style="width:100%">
      <div class="container">
      <br>
        <h2>Juadian, Marvin Sean</h2>
        <p class="title">Frontend</p>
        <p>BSIT Student at Technological University of the Phiilippines </p>
        <p>jaudianmarvin01@gmail.com</p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="img/jawo.png" alt="Mike" style="width:100%">
      <div class="container">
      <br>
        <h2>Manzon, John Eduard</h2>
        <p class="title">Frontend</p>
        <p>BSIT Student at Technological University of the Phiilippines</p>
        <p>mazonjohneduard@gmail.com</p>
      </div>
    </div>
  </div>
           
  <div class="column">
    <div class="card">
      <img src="img/IMG_20210109_205347.jpg" alt="John" style="width:100%">
      <div class="container">
        <br>
        <h2>Perez, Crisjahn</h2>
        <p class="title">Backend</p>
        <p>BSIT Student at Technological University of the Phiilippines</p>
        <p>crisjahn.perez09@gmail.com</p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="img/luke.png" alt="John" style="width:100%">
      <div class="container">
      <br>
        <h2>Toledo, Luke</h2>
        <p class="title">Backend</p>
        <p>BSIT Student at Technological University of the Phiilippines</p>
        <p>luketoledo61@gmail.com</p>
      </div>
    </div>
  </div>

</div>
<h2 style="text-align:center; border-top: 5px solid #5AC7C7; border-bottom: 5px solid #5AC7C7;  border-radius: 5px;">Credits</h2>
<a href="https://www.flaticon.com/free-icons/female" title="female icons">Female icons created by Aficons studio - Flaticon</a><br>
<a href="https://www.flaticon.com/free-icons/businessman" title="businessman icons">Businessman icons created by Vectors Market - Flaticon</a><br>
</div>
 </div>
 

</body>

</html>