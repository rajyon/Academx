<?php
include 'config.php';


session_start();
$user_ID = '';
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
} else {
    $user_ID = $_SESSION["user_id"];
}

$sql = "UPDATE amx_notifications_tbl SET active=0 WHERE poster_ID = '$user_ID'";
$notif_result = mysqli_query($conn, $sql);
?>