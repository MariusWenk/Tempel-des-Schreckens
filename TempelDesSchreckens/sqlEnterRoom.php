<?php
include "sqlConnect.php";

$values = $_POST;
$name = $values['nickname'];
$roomID = $values['roomID'];

$language = "deutsch";
foreach($values as $key => $value){
    if($value == true){
        $language = $key;
    }
}

$playerID = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;

mysqli_query($connect,"INSERT INTO players VALUES ($roomID, $playerID, '$name', '', 'NR',false,true,false,false,0,0,0)");

// mysqli_query($connect, "UPDATE players SET UpdateNecessary=true WHERE RoomID=$roomID");

$connect -> close();

header("Location: game.php?roomID=".$roomID."&playerID=".$playerID);

?>