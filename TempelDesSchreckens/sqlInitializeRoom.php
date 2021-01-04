<?php
include "sqlConnect.php";

$newID = mysqli_fetch_array(mysqli_query($connect,"SELECT RoomID FROM rooms ORDER BY RoomID DESC LIMIT 1"))[0] + 1;

$values = $_POST;
$name = $values['nickname'];

$language = "deutsch";
foreach($values as $key => $value){
    if($value == true){
        $language = $key;
    }
}

mysqli_query($connect,"INSERT INTO rooms VALUES ($newID, '$language',false)");
mysqli_query($connect,"INSERT INTO players VALUES ($newID, 0, '$name', 'Host', 'NR',false,true,true,true,0,0,0,false)");

$connect -> close();

header("Location: game.php?roomID=".$newID."&playerID=0");

?>