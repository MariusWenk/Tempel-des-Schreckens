<?php
include "sqlConnect.php";

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$select = $_GET['select'];

$spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;

mysqli_query($connect,"UPDATE game SET GameMenu=2 WHERE RoomID=$roomID");

$i=0;
while($i < $spielerAnzahl){
    mysqli_query($connect,"UPDATE players SET CardsSelected=false WHERE RoomID=$roomID AND PlayerID=$i");
    $i++;
}
mysqli_query($connect,"UPDATE players SET CardsSelected=true WHERE RoomID=$roomID AND PlayerID=$select");

$connect -> close();

header("Location: game.php?roomID=".$roomID."&playerID=".$playerID);

?>