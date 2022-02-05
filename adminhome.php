<?php
require 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="style_home.css" />
    <link rel="stylesheet" href="style_admin.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href ="img/AcadeMx.png">
    <title>Home</title>
</head>

<body>
    <div>
        <script src="//code.jquery.com/jquery.min.js"></script>
        <div id="nav-placeholder">
            <script>
                $.get("adminhomepage.php", function(data) {
                    $("#nav-placeholder").replaceWith(data);
                });
            </script>
        </div>
    </div>

    <div class="container-fluid" style="background-color: white;height:100vh">
        <div class="contentx">
        <table class="table" border = "3">
       <tr >
           <th style="text-align:center; font-size:22px">Post ID</th>
           <th style="text-align:center; font-size:22px">Post Title</th>
           <th style="text-align:center; font-size:22px">Poster ID</th>
           <th style="text-align:center; font-size:22px">Post Type</th>
           <th style="text-align:center; font-size:22px">Post Group</th>
           <th style="text-align:center; font-size:22px">Post Date</th>
           <th style="text-align:center; font-size:22px">Like Amount</th>
           <th style="text-align:center; font-size:22px">Dislike Amount</th>
           <th style="text-align:center; font-size:22px">ACTION</th>
           <br>
       </tr>
       <?php
          //Display data
          $sql = "SELECT * FROM amx_post_tbl";
          $result = $conn-> query ($sql);
          
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            echo  '<tr>';
                echo '<td style="width: 200px;" align="center">'.$row["post_id"].'</td>'
                  .'<td style="width: 200px;" align="center">'.$row["post_title"].'</td>'
                  .'<td style="width: 200px;" align="center">'.$row["userid"].'</td>'
                  .'<td style="width: 200px;" align="center" >'.$row["post_type"].'</td>'
                  .'<td style="width: 200px;" align="center">'.$row["post_group"].'</td>'
                  .'<td style="width: 200px;" align="center">'.$row["post_date"].'</td>'
                  .'<td style="width: 200px;" align="center">'.$row["like_amount"].'</td>'
                  .'<td style="width: 200px;" align="center">'.$row["dislike_amount"].'</td>'
                  ."<td style = 'width: 200px;' align='center;'><a href='adminviewpost.php? token=" . $row["post_id"] . "'> Viewpost </a><span>|</span><a href='#? token=" . $row["post_id"] . "'> Print </a><span>|</span><a onClick=\"javascript: return confirm('Are you sure you want to Delete this?');\" href='admindelete.php? token=". $row["post_id"] ."'> Delete </a></td>" 
                  .'</tr>';   
            }
          } else {
            echo "0 results";
          }
          ?>
        
    
        </div>
        </div>
        <div>
       <button class = "card_link">Print All</button>
        </div>
    </div>

</body>

</html>

