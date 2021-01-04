<?php
include "sqlConnect.php";

$values = $_POST;
$name = $values['nickname'];
$roomID = $values['roomID'];

$spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;

$nameVergeben = false;
$i=0;
while($i < $spielerAnzahl){
    $nameOthers = mysqli_fetch_array(mysqli_query($connect,"SELECT Name FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
    if($nameOthers == $name){
        $nameVergeben = true;
        $playerID = $i;
    }
    $i++;
}

$connect -> close();

if(!$nameVergeben){
    header("Location: joinroom.php?roomID=".$roomID."&textID=1");
}else{
    header("Location: game.php?roomID=".$roomID."&playerID=".$playerID);
}

?>