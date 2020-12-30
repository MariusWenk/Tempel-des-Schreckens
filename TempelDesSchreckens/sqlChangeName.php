<?php
include "sqlConnect.php";

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$newName = $_GET['newName'];

mysqli_query($connect,"UPDATE players SET Name='$newName' WHERE PlayerID=$playerID AND RoomID='$roomID'");

// mysqli_query($connect, "UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID");

$connect -> close();

header("Location: game.php?roomID=".$roomID."&playerID=".$playerID);

?>