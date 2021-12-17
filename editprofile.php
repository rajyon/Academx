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
     <link rel="stylesheet" href = "style_editprofile.css">
     <title>Document</title>
 </head>
 <body>
     <div class="container">
         <div class="row">
             <div class="col-4 offset-md-4 form-div">
                 <form action="editprofile.php" method="post" enctype="multipart/form-data">
                 
                 <h3 class="text-center">Edit profile</h3>    
                 
                    <?php if(!empty($msg)): ?>
                        <div class =  "alert  <?php echo $css_class; ?>">
                        <?php echo $msg; ?>
                    </div>
                   <?php endif; ?>

                 <div class="form-group text-center">
                    <?php
                        $username = $_SESSION['user_id'];
                        $query = "SELECT * FROM users_img WHERE ID = '$username' LIMIT 1";
                        $results = mysqli_query($conn, $query);
    
                     if(mysqli_num_rows($results))
                     {
                         $row = mysqli_fetch_assoc($results);
                        $profileImage = $row['profile_image'];
                        }
                     ?>
                        <img src="<?php echo $profileImage; ?>" onclick ="triggerClick()" id="profileDisplay"/>        
                        <label for ="profileImage">Profile Image</label>
                        <input type="file" name="profileImage" onchange ="displayImage(this)" id="profileImage" style="display: none;">
                </div>
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea name="bio" id="bio" rclass="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="save-user" class="btn btn-primary btn-block">Save</button>
                        </div>
                 </form>
             </div>
         </div>
     </div>
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
 </body>
 </html>