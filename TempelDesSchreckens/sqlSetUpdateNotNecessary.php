<?php 
include "sqlConnect.php";

$playerID = $_GET['playerID'];
$roomID = $_GET['roomID'];

mysqli_query($connect, "UPDATE players SET UpdateNecessary=false WHERE RoomID=$roomID AND PlayerID=$playerID");

$connect -> close();
?>