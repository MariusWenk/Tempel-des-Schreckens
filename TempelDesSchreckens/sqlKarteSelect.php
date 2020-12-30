<?php
include "sqlConnect.php";

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$select = $_GET['select'];

$spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;

$player = 0;
$i=0;
while($i < $spielerAnzahl){
    mysqli_query($connect,"UPDATE players SET AmZug=false WHERE PlayerID=$i AND RoomID='$roomID'");
    $playerSelected = mysqli_fetch_array(mysqli_query($connect,"SELECT CardsSelected FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
    if($playerSelected){
        $player = $i;
    }
    $i++;
}

$empty = mysqli_fetch_array(mysqli_query($connect,"SELECT Leer FROM players WHERE RoomID=$roomID AND PlayerID=$player"))[0];
$treasure = mysqli_fetch_array(mysqli_query($connect,"SELECT Gold FROM players WHERE RoomID=$roomID AND PlayerID=$player"))[0];
$trap = mysqli_fetch_array(mysqli_query($connect,"SELECT Feuerfalle FROM players WHERE RoomID=$roomID AND PlayerID=$player"))[0];
$kartenGesamt = $empty + $treasure + $trap;

$r = rand(1,$kartenGesamt);
if($r<=$empty){
    mysqli_query($connect,"UPDATE players SET Leer=Leer-1 WHERE PlayerID=$player AND RoomID=$roomID");
    mysqli_query($connect,"UPDATE game SET LeerDisc=LeerDisc+1 WHERE RoomID=$roomID");
    $karteSelected = "Leer";
} else if($r>($kartenGesamt-$trap)){
    mysqli_query($connect,"UPDATE players SET Feuerfalle=Feuerfalle-1 WHERE PlayerID=$player AND RoomID=$roomID");
    mysqli_query($connect,"UPDATE game SET FeuerfallenDisc=FeuerfallenDisc+1 WHERE RoomID=$roomID");
    $karteSelected = "Feuerfalle";
} else{
    mysqli_query($connect,"UPDATE players SET Gold=Gold-1 WHERE PlayerID=$player AND RoomID=$roomID");
    mysqli_query($connect,"UPDATE game SET GoldDisc=GoldDisc+1 WHERE RoomID=$roomID");
    $karteSelected = "Gold";
}

mysqli_query($connect,"UPDATE players SET AmZug=true WHERE PlayerID=$player AND RoomID='$roomID'");

mysqli_query($connect,"UPDATE game SET GameMenu=3 WHERE RoomID=$roomID");

mysqli_query($connect,"UPDATE game SET CardsPlayed=CardsPlayed+1 WHERE RoomID=$roomID");
mysqli_query($connect,"UPDATE game SET KarteSelected='$karteSelected' WHERE RoomID=$roomID");
mysqli_query($connect,"UPDATE game SET KarteSelectedPosition=$select WHERE RoomID=$roomID");

$connect -> close();

header("Location: game.php?roomID=".$roomID."&playerID=".$playerID);

?>