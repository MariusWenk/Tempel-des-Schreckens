<?php

    //$connect = mysqli_connect("fdb28.awardspace.net", "3694719_tempeldesschreckens", "datenbank1", "3694719_tempeldesschreckens") or die (mysqli_error());
    $connect = mysqli_connect("localhost", "root", "", "tempeldesschreckens") or die (mysqli_error());

    $link = "http://localhost/LAMP-Programs/TempelDesSchreckens/joinroom.php";

    $linkstring = $link."?roomID=";
?>