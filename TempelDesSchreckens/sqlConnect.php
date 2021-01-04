<?php

    //$connect = mysqli_connect("localhost", "lamp-programs_TdS", "TdSDaten.PHP", "lamp-programs_TdS") or die (mysqli_error());
    $connect = mysqli_connect("localhost", "root", "", "tempeldesschreckens") or die (mysqli_error());

    $link = "http://lamp-programs.bplaced.net/";
    //$link = "http://localhost/LAMP-Programs/TempelDesSchreckens";

    $linkstring = $link."/joinroom.php?textID=0&roomID=";
?>