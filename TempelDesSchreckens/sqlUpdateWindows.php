<?php   
include "sqlConnect.php";

$playerID = $_GET['playerID'];
$roomID = $_GET['roomID'];
$spielerMenu = $_GET['spielerMenu'];
$linkMenu = $_GET['linkMenu'];

mysqli_query($connect, "UPDATE players SET SpielerMenu=$spielerMenu WHERE PlayerID=$playerID AND RoomID=$roomID");
mysqli_query($connect, "UPDATE players SET LinkMenu=$linkMenu WHERE PlayerID=$playerID AND RoomID=$roomID");

$connect -> close();

//header("Location: game.php?roomID=".$roomID."&playerID=".$playerID);
?>