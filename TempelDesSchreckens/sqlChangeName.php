<?php
include "sqlConnect.php";

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$newName = $_GET['newName'];

$spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;

$nameVergeben = false;
$i=0;
while($i < $spielerAnzahl){
    $nameOthers = mysqli_fetch_array(mysqli_query($connect,"SELECT Name FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
    if($nameOthers == $newName){
        $nameVergeben = true;
    }
    $i++;
}

if(!$nameVergeben){
    mysqli_query($connect,"UPDATE players SET Name='$newName' WHERE PlayerID=$playerID AND RoomID='$roomID'");

    $spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;
    $i=0;
    while($i<$spielerAnzahl){
        if($i != $playerID){
            mysqli_query($connect, "UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID AND PlayerID=$playerID");
        }
        $i++;
    }
}

$connect -> close();

?>