<?php
include "sqlConnect.php";

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];

$spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;


$goldDisc = mysqli_fetch_array(mysqli_query($connect,"SELECT GoldDisc FROM game WHERE RoomID=$roomID"))[0];
$goldGen = mysqli_fetch_array(mysqli_query($connect,"SELECT GoldGen FROM game WHERE RoomID=$roomID"))[0];
$feuerfallenDisc = mysqli_fetch_array(mysqli_query($connect,"SELECT FeuerfallenDisc FROM game WHERE RoomID=$roomID"))[0];
$feuerfallenGen = mysqli_fetch_array(mysqli_query($connect,"SELECT FeuerfallenGen FROM game WHERE RoomID=$roomID"))[0];

$check = true;

if($goldDisc == $goldGen){
    mysqli_query($connect,"UPDATE game SET GameMenu=4 WHERE RoomID=$roomID");
    mysqli_query($connect,"UPDATE game SET Winner='Abenteurer' WHERE RoomID=$roomID");
    $check = false;
}else if($feuerfallenDisc == $feuerfallenGen){
    mysqli_query($connect,"UPDATE game SET GameMenu=4 WHERE RoomID=$roomID");
    mysqli_query($connect,"UPDATE game SET Winner='Waechterinnen' WHERE RoomID=$roomID");
    $check = false;
}else{
    mysqli_query($connect,"UPDATE game SET GameMenu=1 WHERE RoomID=$roomID");
}

$cardsPlayed = mysqli_fetch_array(mysqli_query($connect,"SELECT CardsPlayed FROM game WHERE RoomID=$roomID"))[0];

if($cardsPlayed == $spielerAnzahl){
    mysqli_query($connect,"UPDATE game SET CardsPlayed=0 WHERE RoomID=$roomID");
    mysqli_query($connect,"UPDATE game SET Runde=Runde+1 WHERE RoomID=$roomID");
}

$runde = mysqli_fetch_array(mysqli_query($connect,"SELECT Runde FROM game WHERE RoomID=$roomID"))[0];

if($runde == 4){
    mysqli_query($connect,"UPDATE game SET GameMenu=4 WHERE RoomID=$roomID");
    mysqli_query($connect,"UPDATE game SET Winner='Waechterinnen' WHERE RoomID=$roomID");
    $check = false;
}

$i=0;
while($i<$spielerAnzahl){
    if($i != $playerID){
        mysqli_query($connect, "UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID AND PlayerID=$playerID");
    }
    $i++;
}

$connect -> close();

if($cardsPlayed == $spielerAnzahl && $check){
    header("Location: sqlSetCards.php?roomID=".$roomID."&playerID=".$playerID);
}

?>