<?php
include "sqlConnect.php";

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];

$spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;

$runde = mysqli_fetch_array(mysqli_query($connect,"SELECT Runde FROM game WHERE RoomID=$roomID"))[0];

$leer = mysqli_fetch_array(mysqli_query($connect,"SELECT LeerGen FROM game WHERE RoomID=$roomID"))[0] - mysqli_fetch_array(mysqli_query($connect,"SELECT LeerDisc FROM game WHERE RoomID=$roomID"))[0];
$gold = mysqli_fetch_array(mysqli_query($connect,"SELECT GoldGen FROM game WHERE RoomID=$roomID"))[0] - mysqli_fetch_array(mysqli_query($connect,"SELECT GoldDisc FROM game WHERE RoomID=$roomID"))[0];
$feuerfalle = mysqli_fetch_array(mysqli_query($connect,"SELECT FeuerfallenGen FROM game WHERE RoomID=$roomID"))[0] - mysqli_fetch_array(mysqli_query($connect,"SELECT FeuerfallenDisc FROM game WHERE RoomID=$roomID"))[0];

$ges = (5-$runde) * $spielerAnzahl;
$i=0;
while($i < $spielerAnzahl){
    mysqli_query($connect,"UPDATE players SET Leer=0 WHERE PlayerID=$i AND RoomID=$roomID");
    mysqli_query($connect,"UPDATE players SET Gold=0 WHERE PlayerID=$i AND RoomID=$roomID");
    mysqli_query($connect,"UPDATE players SET Feuerfalle=0 WHERE PlayerID=$i AND RoomID=$roomID");
    $j=0;
    while($j<(5-$runde)){
        $r = rand(1,$ges);
        if($r<=$leer){
            mysqli_query($connect,"UPDATE players SET Leer=Leer+1 WHERE PlayerID=$i AND RoomID=$roomID");
            $leer--;
        } else if($r>($ges-$feuerfalle)){
            mysqli_query($connect,"UPDATE players SET Feuerfalle=Feuerfalle+1 WHERE PlayerID=$i AND RoomID=$roomID");
            $feuerfalle--;
        } else{
            mysqli_query($connect,"UPDATE players SET Gold=Gold+1 WHERE PlayerID=$i AND RoomID=$roomID");
            $gold--;
        }
        $ges--;
        $j++;
    }
    $i++;
}

$i=0;
while($i<$spielerAnzahl){
    if($i != $playerID){
        mysqli_query($connect, "UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID AND PlayerID=$playerID");
    }
    $i++;
}

$connect -> close();

?>