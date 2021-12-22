
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style_about.css">
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
  <h1 style=" text-transform: uppercase">Acade<span>Mx</span></h1><br>
  <div class="row">
  <div class="box">
  <h3 style="color: red;">MISSION</h3>
  To empower and give the student, alumni, organization, and university achieve more and give power to share and make the university more open and connected. 
  </div>
  <div class="box">
  <h3 style="color: green;">VISION</h3>
  AcadeMx sets the standards to create a transformative educational experience for students and alumuni focused on deep disciplinary knowledge; problem solving; leadership, communication, and interpersonal skills; and personal health and well-being.
  </div>
  </div>
</div>
<br>
<h2 style="text-align:center">Our Team</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="img/catss.PNG" alt="Jane" style="width:100%">
      <div class="container">
      <br>
        <h2>Juadian, Marvin Sean</h2>
        <p class="title">CEO & Founder</p>
        <p>BSIT Student at Technological University of the Phiilippines </p>
        <p>jaudianmarvin01@gmail.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="img/akiropandesal.PNG" alt="Mike" style="width:100%">
      <div class="container">
      <br>
        <h2>Manzon, John Eduard</h2>
        <p class="title">Art Director</p>
        <p>BSIT Student at Technological University of the Phiilippines</p>
        <p>mike@example.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>
           
  <div class="column">
    <div class="card">
      <img src="img/IMG_20210109_205347.jpg" alt="John" style="width:100%">
      <div class="container">
        <br>
        <h2>Perez, Crisjahn</h2>
        <p class="title">Designer</p>
        <p>BSIT Student at Technological University of the Phiilippines</p>
        <p>crisjahn.perez09@gmail.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="img/Vincent_van_Gogh_-_Self-Portrait_-_Google_Art_Project.jpg" alt="John" style="width:100%">
      <div class="container">
      <br>
        <h2>Toledo, Luke</h2>
        <p class="title">Designer</p>
        <p>BSIT Student at Technological University of the Phiilippines</p>
        <p>luketoledo61@gmail.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

</div>
</div>
 </div>
</body>

</html>