<?php
include 'config.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
}
$userID = $_SESSION["user_id"];
$table_data="";
$profile_name=$_SESSION['Profile_Name'];
$showDivFlag=false;
if (isset($_POST['btn_create'])) {
    $grpName = $_POST['txt_name'];
    $grpCode = $_POST['txt_code'];
    $date = date("Y-m-d");
    $presql = "SELECT * FROM amx_group_tbl WHERE group_name='$grpName'";
    $preresult = mysqli_query($conn,$presql);
    if(mysqli_num_rows($preresult)>0){
        echo "<script> alert('Group Already Exists! : [Change Group Name]')</script>";
    }
    else{
        $sql = "INSERT INTO amx_group_tbl SET group_code='$grpCode', group_name='$grpName', date_created='$date', created_by='$profile_name'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql1 = "INSERT INTO amx_group_transac SET group_code='$grpCode', member_ID = '$userID', date_joined = '$date'";
        $result1 = mysqli_query($conn, $sql1);
        if ($result1) {
            echo "<script> alert('Group Created!')</script>";
        }
    } else {
        echo "<script> alert('Group Already Exists! : [Change Group Code]')</script>";
    }
    }
    
}

if (isset($_POST["btn_search"])){
    $to_search = $_POST['txt_search'];
    $num=0;

    $sql = "SELECT * FROM amx_group_tbl WHERE group_code LIKE '$to_search%' OR group_name LIKE '$to_search%'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if(mysqli_num_rows($result)>0){
            while($rows=mysqli_fetch_assoc($result)){
                $num++;
                
                $table_data.='<tbody><td>'.$rows['group_name'].'</td><td>'.$rows['created_by'].'</td><td>'.$rows['date_created'].'</td><td><a href="join.php?token='.$rows['group_code'].'" style="text-decoration:none">Join</a></td><tr></tbody>';
                $showDivFlag=true;
            }
    }
        else{
            $table_data='<tr><td colspan="6"><center>Group not found!</center></td></tr>';
            $showDivFlag=true;
        }
}
    else{
        $table_data='<tr><td colspan="6"><center>Group not found!</center></td></tr>';
        $showDivFlag=true;
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="style_group.css" />
    <link rel="icon" type="image/png" href ="img/tablogo.png">
    <title>Group</title>
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
        <h2 style="text-align:center; border-top: 5px solid #5AC7C7; border-bottom: 5px solid #5AC7C7;  border-radius: 5px;">Group</h2>
            <div  <?php if ($showDivFlag===true){?>style="display:none"<?php } ?> style="height: 60%;border:solid thin #aaa; padding: 20px; background-color:#3F3F3F;color:white">
                <form name="frmCreate" method="post">
                    <h1><span style="color: #5AC7C7;">Create</span> a group</h1><br>

                    Group Name:
                    <div class="input-field">
                        <i class="fas fa-users"></i><input minlength="4" maxlength="25" type="text" name="txt_name" placeholder="Enter name here..." required />
                    </div>
                    Group Code:
                    <div class="input-field">
                        <i class="fas fa-hashtag"></i><input minlength="4" maxlength="25" type="text" name="txt_code" placeholder="Enter code here..." required />
                    </div>
                    <input style="width:100px; float:right" type="submit" name="btn_create" value="Create" />
                </form>
            </div>
            <br>

            <div style="height: 42%;border:solid thin #aaa; padding: 20px; background-color:#3F3F3F;color:white">
                <form name="frmJoin" method="post">
                    <h1><span style="color: #5AC7C7;">Join</span> a group</h1><br>
                    Group Code/Name:
                    <div class="input-field">
                        <i class="fas fa-search"></i><input type="text" name="txt_search" placeholder="Enter code/name here..." required />
                    </div>
                    <input style="width:100px; float:right" type="submit" name="btn_search" value="Search" />
                </form>
            </div>
            <div <?php if ($showDivFlag===true){?>style="height: 40%;border:solid thin #aaa; padding: 20px; background-color:#3F3F3F;color:white;display:block;overflow:auto"<?php } ?> style="height: 40%;border:solid thin #aaa; padding: 20px; background-color:#3F3F3F;color:white;display:none;overflow:auto ">
                <h1>Search result</h1>
                <table class="content-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Creator</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <?php 
                    echo $table_data;
                    ?>
     
                    </table>
            </div>


        </div>
    </div>
</body>

</html>
