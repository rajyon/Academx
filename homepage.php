<?php
include 'config.php';


session_start();
$user_ID = '';
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
} else {
    $user_ID = $_SESSION["user_id"];
}
?>

<?php
$i = 0;
$display = "";
$sql = "SELECT * FROM amx_notifications_tbl WHERE poster_ID = '$user_ID' ORDER BY ID DESC";
$notif_result = mysqli_query($conn, $sql);
if ($notif_result) {
    if (mysqli_num_rows($notif_result) > 0) {
        while ($rows = mysqli_fetch_assoc($notif_result)) {
            if ($rows['active'] == 1) {
                $i++;
                $display .= '<a href="viewpost.php?token=' . $rows['post_ID'] . '"><span id="notif" style="font-size:16px;color:white">' . $rows['content'] . '</span><i class="fas fa-circle" style="float:right;color:white;font-size:10px;padding-top:12px"></i><br><span id="notif_date" style="font-size:12px;color:#5AC7C7">' . $rows['action_time'] . '</span></a>';
            } else {
                $display .= '<a href="viewpost.php?token=' . $rows['post_ID'] . '"><span id="notif" style="font-size:16px;color:white">' . $rows['content'] . '</span><br><span id="notif_date" style="font-size:12px;color:#5AC7C7">' . $rows['action_time'] . '</span></a>';
            }
        }
    } else {
        $display .= '<br><center><p style="color:white">No Notifications.</p></center>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="style_homepage.css" />
    <link rel="icon" type="image/png" href ="img/tablogo.png">
    <title>Homepage</title>
</head>

<body>
    <div class="master">
        <header>
            <div class="left_area1">
                <h3>Acade<span>Mx</span></h3>
            </div>
            <div class="dropdown">
                <button onclick="myFunction()" class="dropbtn"><i class="fas fa-bell" style="font-size:20px;color:white;pointer-events:none;"></i><?php $whiledogs = 0; if ($i > 0) {$x = $i;echo '<span class="badge" id="badge">' . $x . '</span>';} ?></button>
                <div id="myDropdown" class="dropdown-content">
                    <div style="background-color:#5AC7C7;text-align:center;position:fixed;width:350px">Notifications</div>
                    <br>
                    <?php echo $display; ?>

                </div>
            </div>
        </header>
        <div class="sidebar">
            <center>
                <?php
                $username = $_SESSION['user_id'];
                $query = "SELECT * FROM amx_users_img WHERE ID = '$username' LIMIT 1";
                $results = mysqli_query($conn, $query);

                if (mysqli_num_rows($results)) {
                    $row = mysqli_fetch_assoc($results);
                    $profileImage = $row['profile_image'];
                }
                ?>
                <img src="<?php echo $profileImage; ?>" class="profile_image" alt="">
                <?php
                $profileName = "";
                $username = $_SESSION['user_id'];
                $query = "SELECT * FROM amx_users_tbl WHERE ID = '$username' LIMIT 1";
                $results = mysqli_query($conn, $query);

                if (mysqli_num_rows($results)) {
                    $row = mysqli_fetch_assoc($results);
                    $profileName = $row['fname'] . ' ' . $row['lname'];
                }
                $_SESSION['Profile_Name'] = $profileName;
                ?>
                <h4><?php echo $profileName; ?></h4>
                <?php
                $profileBio = "";
                $username = $_SESSION['user_id'];
                $query = "SELECT * FROM amx_users_img WHERE ID = '$username' LIMIT 1";
                $results = mysqli_query($conn, $query);

                if (mysqli_num_rows($results)) {
                    $row = mysqli_fetch_assoc($results);
                    $profileBio = $row['bio'];
                }
                ?>
                <h5><?php echo $profileBio; ?></h5>
            </center>
            <a href="home.php"><i class="fas fa-home"></i><span>Home</span></a>
            <a href="profile.php"><i class="far fa-address-card"></i><span>Profile</span></a>
            <a href="myposts.php"><i class="far fa-sticky-note"></i><span>My Posts</span></a>
            <a href="group.php"><i class="fas fa-users"></i><span>Group</span></a>
            <a href="about.php"><i class="fas fa-info-circle"></i><span>About Us</span></a>
            <div style="vertical-align: sub;">
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
            </div>


        </div>
    </div>

</body>

</html>
<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
        document.getElementById("badge").style.display = "none";
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {

        }
        xhttp.open("GET", "notif_clear.php");
        xhttp.send();
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>