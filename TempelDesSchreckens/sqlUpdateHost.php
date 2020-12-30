<?php 
include "sqlConnect.php";

$playerID = $_GET['playerID'];
$roomID = $_GET['roomID'];
$spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;

if($spielerAnzahl > 1){
    mysqli_query($connect, "UPDATE players SET Status='' WHERE PlayerID=$playerID AND RoomID=$roomID");
    if($spielerAnzahl-1-$playerID > 0){
        $newID = $playerID+1;
            mysqli_query($connect, "UPDATE players SET Status='Host' WHERE PlayerID=$newID AND RoomID=$roomID");
    } else{
        mysqli_query($connect, "UPDATE players SET Status='Host' WHERE PlayerID=0 AND RoomID=$roomID");
    }

    // mysqli_query($connect, "UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID");

}

$connect -> close();

header("Location: game.php?roomID=".$roomID."&playerID=".$playerID);
?>