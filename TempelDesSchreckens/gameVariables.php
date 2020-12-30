<?php
        include "sqlConnect.php";

        $roomID = $_GET['roomID'];
        $playerID = $_GET['playerID'];

        $initialisiert = mysqli_fetch_array(mysqli_query($connect,"SELECT Initialisiert FROM rooms WHERE RoomID=$roomID"))[0];

        $spielerAnzahl = mysqli_fetch_array(mysqli_query($connect,"SELECT PlayerID FROM players WHERE RoomID=$roomID ORDER BY PlayerID DESC LIMIT 1"))[0] + 1;
        
        $i=0;
        $name = new SplFixedArray($spielerAnzahl);
        $role = new SplFixedArray($spielerAnzahl);
        $status = new SplFixedArray($spielerAnzahl);
        $AmZug = new SplFixedArray($spielerAnzahl);
        $CardsSelected = new SplFixedArray($spielerAnzahl);
        $empty = new SplFixedArray($spielerAnzahl);
        $treasure = new SplFixedArray($spielerAnzahl);
        $trap = new SplFixedArray($spielerAnzahl);
        $kartenGesamt = new SplFixedArray($spielerAnzahl);

        while($i < $spielerAnzahl){
            $name[$i] = mysqli_fetch_array(mysqli_query($connect,"SELECT Name FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
            $role[$i] = mysqli_fetch_array(mysqli_query($connect,"SELECT Role FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
            $status[$i] = mysqli_fetch_array(mysqli_query($connect,"SELECT Status FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
            $AmZug[$i] = mysqli_fetch_array(mysqli_query($connect,"SELECT AmZug FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
            $CardsSelected[$i] = mysqli_fetch_array(mysqli_query($connect,"SELECT CardsSelected FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
            $empty[$i] = mysqli_fetch_array(mysqli_query($connect,"SELECT Leer FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
            $treasure[$i] = mysqli_fetch_array(mysqli_query($connect,"SELECT Gold FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
            $trap[$i] = mysqli_fetch_array(mysqli_query($connect,"SELECT Feuerfalle FROM players WHERE RoomID=$roomID AND PlayerID=$i"))[0];
            $kartenGesamt[$i] = $empty[$i] + $treasure[$i] + $trap[$i];
            if($AmZug[$i]){
                $spielerAmZugIndex = $i;
            }
            if($CardsSelected[$i]){
                $spielerCardsSelectedIndex = $i;
            }
            $i++;
        }
        $spielerMenu = mysqli_fetch_array(mysqli_query($connect,"SELECT SpielerMenu FROM players WHERE RoomID=$roomID AND PlayerID=$playerID"))[0];
        $linkMenu = mysqli_fetch_array(mysqli_query($connect,"SELECT LinkMenu FROM players WHERE RoomID=$roomID AND PlayerID=$playerID"))[0];
        
        if($initialisiert){
            $gameMenu = mysqli_fetch_array(mysqli_query($connect,"SELECT GameMenu FROM game WHERE RoomID=$roomID"))[0];  
            $emptyGen = mysqli_fetch_array(mysqli_query($connect,"SELECT LeerGen FROM game WHERE RoomID=$roomID"))[0];
            $emptyDisc = mysqli_fetch_array(mysqli_query($connect,"SELECT LeerDisc FROM game WHERE RoomID=$roomID"))[0];
            $treasureGen = mysqli_fetch_array(mysqli_query($connect,"SELECT GoldGen FROM game WHERE RoomID=$roomID"))[0];
            $treasureDisc = mysqli_fetch_array(mysqli_query($connect,"SELECT GoldDisc FROM game WHERE RoomID=$roomID"))[0];
            $trapGen = mysqli_fetch_array(mysqli_query($connect,"SELECT FeuerfallenGen FROM game WHERE RoomID=$roomID"))[0];
            $trapDisc = mysqli_fetch_array(mysqli_query($connect,"SELECT FeuerfallenDisc FROM game WHERE RoomID=$roomID"))[0];
            $karteSelected = mysqli_fetch_array(mysqli_query($connect,"SELECT KarteSelected FROM game WHERE RoomID=$roomID"))[0];
            $karteSelectedPosition = mysqli_fetch_array(mysqli_query($connect,"SELECT KarteSelectedPosition FROM game WHERE RoomID=$roomID"))[0];
            $karteSelectedPosition = mysqli_fetch_array(mysqli_query($connect,"SELECT KarteSelectedPosition FROM game WHERE RoomID=$roomID"))[0];
            $gewinner = mysqli_fetch_array(mysqli_query($connect,"SELECT Winner FROM game WHERE RoomID=$roomID"))[0];
        }else{
            $gameMenu = 0; //0 hier wichtig
            $emptyGen = 0;
            $emptyDisc = 0;
            $treasureGen = 0;
            $treasureDisc = 0;
            $trapGen = 0;
            $trapDisc = 0;
            $karteSelected = "Keine";
            $karteSelectedPosition = 0;
            $karteSelectedPosition = 0;
            $gewinner = "Niemand";
        }
        
        $connect -> close();
    ?>