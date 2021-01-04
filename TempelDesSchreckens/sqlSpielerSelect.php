<?php
include "sqlConnect.php";

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];
$select = $_GET['select'];

$spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;
$chooseCardStatus = mysqli_fetch_array(mysqli_query($connect,"SELECT ChooseCardStatus FROM game WHERE RoomID=$roomID"))[0];

if($chooseCardStatus == 0){
    mysqli_query($connect,"UPDATE game SET ChooseCardStatus=1 WHERE RoomID=$roomID");

    mysqli_query($connect,"UPDATE game SET GameMenu=2 WHERE RoomID=$roomID");

    $i=0;
    while($i < $spielerAnzahl){
        mysqli_query($connect,"UPDATE players SET CardsSelected=false WHERE RoomID=$roomID AND PlayerID=$i");
        $i++;
    }
    mysqli_query($connect,"UPDATE players SET CardsSelected=true WHERE RoomID=$roomID AND PlayerID=$select");

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