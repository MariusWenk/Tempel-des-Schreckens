<?php
include "sqlConnect.php";

$roomID = $_GET['roomID'];
$playerID = $_GET['playerID'];

$spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;

$emptyGen = mysqli_fetch_array(mysqli_query($connect,"SELECT Leer FROM doors WHERE Spielerzahl=$spielerAnzahl "))[0];
$treasureGen = mysqli_fetch_array(mysqli_query($connect,"SELECT Gold FROM doors WHERE Spielerzahl=$spielerAnzahl"))[0];
$trapGen = mysqli_fetch_array(mysqli_query($connect,"SELECT Feuerfallen FROM doors WHERE Spielerzahl=$spielerAnzahl"))[0];

$abenteurer = mysqli_fetch_array(mysqli_query($connect,"SELECT Abenteurer FROM roles WHERE Spielerzahl=$spielerAnzahl"))[0];
$waechterinnen = mysqli_fetch_array(mysqli_query($connect,"SELECT Waechterinnen FROM roles WHERE Spielerzahl=$spielerAnzahl"))[0];

$ges = $abenteurer + $waechterinnen;
$i = 0;
while($i < $spielerAnzahl){
    $r = rand(1, $ges-$i);
    if($r<=$abenteurer){
        mysqli_query($connect,"UPDATE players SET Role='Abenteurer' WHERE PlayerID=$i AND RoomID='$roomID'");
        $abenteurer--;
    } else{
        mysqli_query($connect,"UPDATE players SET Role='Waechterin' WHERE PlayerID=$i AND RoomID='$roomID'");
        $waechterinnen--;
    }
    $i++;
}

$r2 = rand(0,($spielerAnzahl-1));
mysqli_query($connect,"UPDATE players SET AmZug=false WHERE PlayerID=0 AND RoomID='$roomID'");
mysqli_query($connect,"UPDATE players SET AmZug=true WHERE PlayerID=$r2 AND RoomID='$roomID'");

mysqli_query($connect,"INSERT INTO game VALUES ($roomID, $emptyGen, $treasureGen, $trapGen, 0, 0, 0, 0, $spielerAnzahl, 0, 1, 'Leer', 0, '', '', 0)");

mysqli_query($connect,"UPDATE rooms SET Initialisiert=true WHERE RoomID='$roomID'");

$connect -> close();

header("Location: sqlSetCards.php?roomID=".$roomID."&playerID=".$playerID);

?>