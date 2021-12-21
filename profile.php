<?php
session_start();
include 'config.php';
include 'imageProcess.php'

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

    <div class="container-fluid" style="background-color: white;height:100vh">
<div style="background-color: white; width:84%;margin-left:16%;height:100%;padding-top:70px;padding-left:10px;margin-bottom:0;border: 5px solid #3F3F3F;">
    <form action="profile.php" method="post" enctype="multipart/form-data">
                    <h3 class="text-center">Edit profile</h3>

                    <?php if (!empty($msg)) : ?>
                        <div class="alert  <?php echo $css_class; ?>">
                            <?php echo $msg; ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group text-center">
                        <?php
                        $username = $_SESSION['user_id'];
                        $query = "SELECT * FROM users_img WHERE ID = '$username' LIMIT 1";
                        $results = mysqli_query($conn, $query);

                        if (mysqli_num_rows($results)) {
                            $row = mysqli_fetch_assoc($results);
                            $profileImage = $row['profile_image'];
                            $profileBio = $row['bio'];
                        }
                        ?>
                        <img src="<?php echo $profileImage; ?>" onclick="triggerClick()" id="profileDisplay" style="width: 150px;height: 150px; border-radius: 100px;margin-bottom: 10px;" />
                        <label for="profileImage">Profile Image</label>
                        <input type="file" name="profileImage" onchange="displayImage(this)" id="profileImage" style="display: none;">
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea name="bio" id="bio" rclass="form-control"><?php echo $profileBio; ?></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="save-user" class="btn btn-primary btn-block">Save</button>
                    </div>
                </form>
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