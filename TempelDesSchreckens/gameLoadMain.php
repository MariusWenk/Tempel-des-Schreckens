<!DOCTYPE html>

    <?php
        include "sqlConnect.php";

        include "gameVariables.php";
    ?>
    
    <html lang="de">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <head>
            <Title>Tempel des Schreckens</Title>

            <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

            <link rel="stylesheet" type="text/CSS" href="main.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        </head>

        <body>

            
            <section id="game"> <?php

            if($gameMenu == 0){
                echo "<h3>Der Host kann das Spiel starten, wenn zwischen 3 und 10 Spieler dabei sind.</h3>";
                echo "<section class=\"anzeige button\" id=\"gamebutton\">";
                    echo "<p class=\"button\">Start</p>";
                echo "</section>";
                echo "<h3 id=\"fehlerStart\"></h3>";
            }
            else if($gameMenu == 1){
                echo "<h3 id=\"game1title\">Spieler zum Ziehen der Karte wählen (Spieler am Zug: ".$name[$spielerAmZugIndex]." (nicht wählbar)):</h3>";
                echo "<p id=\"game1main\">"; 
                    $i = 0;
                    while($i < $spielerAnzahl){
                        echo "<section class=\"anzeige spielerA button\" id=\"spieler".$i."A\"><p class=\"button\" id=\"spieler".$i."\">";
                            if($spielerAnzahl > $i && $spielerAmZugIndex != $i && $kartenGesamt[$i] != 0){
                                echo $name[$i]." (".$kartenGesamt[$i].")";
                            }else{
                                echo "/";
                            }
                        echo "</p></section>";
                        $i++;
                    }
                echo "</p>";
            }
            else if($gameMenu == 2){
                echo "<h3 id=\"game2title\">Karte wählen (aus der Auslage von: ".$name[$spielerCardsSelectedIndex]."):</h3>";
                echo "<p id=\"game2main\">";
                    $i = 0;
                    while($i < $kartenGesamt[$spielerCardsSelectedIndex]){
                        echo "<section class=\"karte button\" id=\"karte".$i."A\"><p class=\"button\">";
                            if($kartenGesamt[$spielerCardsSelectedIndex] > $i){
                                $shift="0%";
                                if($kartenGesamt[$spielerCardsSelectedIndex] == 4){
                                    $shift = "80%";                                    
                                }else if($kartenGesamt[$spielerCardsSelectedIndex] == 3){
                                    $shift = "170%";
                                }else if($kartenGesamt[$spielerCardsSelectedIndex] == 2){
                                    $shift = "240%";
                                }else if($kartenGesamt[$spielerCardsSelectedIndex] == 1){
                                    $shift = "340%%";
                                }
                                echo "<img class=\"button\" id=\"karte".$i."\" src=\"Back.PNG\" width=\"200%\" height=\"10%\" style=\"transform:rotate(90deg); margin-left:+".$shift.";\">";                                }
                            echo "</p></section>";
                        $i++;
                    }
                echo "</p>";
            }
            else if($gameMenu == 3){
                echo "<h3 id=\"game3title\">Gewählte Karte aus der Auslage von: ".$name[$spielerCardsSelectedIndex].":</h3>";
                echo "<p id=\"game3main\">";
                    $i = 0;
                    while($i < $kartenGesamt[$spielerCardsSelectedIndex]+1){
                        echo " <section class=\"karte button\" id=\"karte".$i."A\"><p class=\"button\">";
                            if($kartenGesamt[$spielerCardsSelectedIndex] > $i-1){
                                $shift="0%";
                                if($kartenGesamt[$spielerCardsSelectedIndex] == 4){
                                    $shift = "0%";                                    
                                }else if($kartenGesamt[$spielerCardsSelectedIndex] == 3){
                                    $shift = "80%";
                                }else if($kartenGesamt[$spielerCardsSelectedIndex] == 2){
                                    $shift = "170%";
                                }else if($kartenGesamt[$spielerCardsSelectedIndex] == 1){
                                    $shift = "240%";
                                }
                                if($karteSelectedPosition == $i){
                                    if($karteSelected == "Leer"){
                                        echo "<img src=\"Empty.PNG\" width=\"125%\" height=\"10%\" style=\"margin-top: -42%; padding-left:+35%; margin-left:+".$shift.";\">";
                                    }else if($karteSelected == "Gold"){
                                        echo "<img src=\"Treasure.PNG\" width=\"125%\" height=\"10%\" style=\"margin-top: -42%; padding-left:+35%; margin-left:+".$shift.";\">";
                                    }else if($karteSelected == "Feuerfalle"){
                                        echo "<img src=\"Trap.PNG\" width=\"130%\" height=\"10%\" style=\"margin-top: -42%; padding-left:+35%; margin-left:+".$shift.";\">";
                                    }
                                }else{
                                    echo "<img src=\"Back.PNG\" width=\"200%\" height=\"10%\" style=\"transform:rotate(90deg); margin-left:+".$shift.";\">";
                                }
                            }
                        echo "</p></section>";
                        $i++;
                    }
                echo "</p>";    
                echo "<h3 id=\"game3subtitle\" style=\"margin-top: 26%\">".$name[$spielerAmZugIndex]." ist am Zug.</h3>";
                    echo "<section class=\"anzeige button\" id=\"game3button\">";
                        echo "<p class=\"button\">Ok</p>";
                    echo "</section>";
            }
            else if($gameMenu == 4){
                echo "<h3 id=\"game4title\">Das Spiel ist aus. Die ".$gewinner." haben gewonnen.</h3>";
            }

            ?>  </section>

            <script>
                $(document).ready(function(){
                    $("#gamebutton").click(function(){
                        if("<?php echo $status[$playerID];?>" != "Host"){
                            $("#fehlerStart").append("Du bist kein Host");
                        } else if(parseInt("<?php echo $spielerAnzahl;?>") < 3 || parseInt("<?php echo $spielerAnzahl;?>") > 10){
                            $("#fehlerStart").append("Das Spiel ist für die aktuelle Spielerzahl nicht möglich.");
                        }else {
                            xmlRequest("sqlInitializeGame.php");
                        }
                    });
                    $("#game3button").click(function(){
                        if("<?php echo $status[$playerID];?>" == "Host"){
                            xmlRequest("sqlEndGameMenu3.php");
                        }
                    });
                    

                    if("<?php echo $spielerAmZugIndex;?>" == "<?php echo $playerID;?>"){
                        var i = 0;
                        // while(i<parseInt("<?php echo $spielerAnzahl;?>")){
                        //     $("#spieler".concat(i).concat("A")).click(function(){
                        //         $("#game1title").append("Du bist kein Host");
                        //         //if(parseInt("<?php echo $spielerAnzahl;?>") > i && "<?php echo $spielerAmZugIndex;?>" != "0" && "<?php if($spielerAnzahl > 0){echo $kartenGesamt[intval("<script>alert(i)</script>")];}?>" != "0"){
                        //             spielerSelect(i);
                        //         //}
                        //     });
                        //     i++;
                        // }

                        $("#spieler0A").click(function(){
                            if(parseInt("<?php echo $spielerAnzahl;?>") > 0 && "<?php echo $spielerAmZugIndex;?>" != "0" && "<?php if($spielerAnzahl > 0){echo $kartenGesamt[0];}?>" != "0"){
                                spielerSelect(0);
                            }
                        });
                        $("#spieler1A").click(function(){
                            if(parseInt("<?php echo $spielerAnzahl;?>") > 1 && "<?php echo $spielerAmZugIndex;?>" != "1" && "<?php if($spielerAnzahl > 1){echo $kartenGesamt[1];}?>" != "0"){
                                spielerSelect(1);
                            }
                        });
                        $("#spieler2A").click(function(){
                            if(parseInt("<?php echo $spielerAnzahl;?>") > 2 && "<?php echo $spielerAmZugIndex;?>" != "2" && "<?php if($spielerAnzahl > 2){echo $kartenGesamt[2];}?>" != "0"){
                                spielerSelect(2);
                            }
                        });
                        $("#spieler3A").click(function(){
                            if(parseInt("<?php echo $spielerAnzahl;?>") > 3 && "<?php echo $spielerAmZugIndex;?>" != "3" && "<?php if($spielerAnzahl > 3){echo $kartenGesamt[3];}?>" != "0"){
                                spielerSelect(3);
                            }
                        });

                        function spielerSelect(spielerID){
                            $.ajax({
                            type: "GET",
                            url: "sqlSpielerSelect.php" ,
                            data: {playerID: "<?php echo $playerID;?>", roomID: "<?php echo $roomID;?>", select: spielerID},
                            success : function() { 
                                var loadGame = "gameLoad.php?playerID=".concat("<?php echo $playerID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
                                $("#spielertext").load(loadGame.concat(" #spielertext"));
                                $("#linktext").load(loadGame.concat(" #linktext"));
                                $("#spielernamenlinkfeld").load(loadGame.concat(" #spielernamenlinkfeld"));
                                $("#spielername").load(loadGame.concat(" #spielername"));
                                $("#rolle").load(loadGame.concat(" #rolle"));
                                $("#status").load(loadGame.concat(" #status"));
                                $("#host").load(loadGame.concat(" #host"));
                                $("#statistikZahlen").load(loadGame.concat(" #statistikZahlen"));
                                $("#eigenKartenZahlen").load(loadGame.concat(" #eigeneKartenZahlen"));
                                var loadMain = "gameLoadMain.php?playerID=".concat("<?php echo $playerID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
                                $("#game").load(loadMain);
                            }
                        });
                        }

                        $("#karte0").click(function(){
                            if(parseInt("<?php echo $kartenGesamt[$spielerCardsSelectedIndex];?>") > 0){
                                karteSelect(0);
                            }
                        });
                        $("#karte1").click(function(){
                            if(parseInt("<?php echo $kartenGesamt[$spielerCardsSelectedIndex];?>") > 1){
                                karteSelect(1);
                            }
                        });
                        $("#karte2").click(function(){
                            if(parseInt("<?php echo $kartenGesamt[$spielerCardsSelectedIndex];?>") > 2){
                                karteSelect(2);
                            }
                        });
                        $("#karte3").click(function(){
                            if(parseInt("<?php echo $kartenGesamt[$spielerCardsSelectedIndex];?>") > 3){
                                karteSelect(3);
                            }
                        });
                        $("#karte4").click(function(){
                            if(parseInt("<?php echo $kartenGesamt[$spielerCardsSelectedIndex];?>") > 4){
                                karteSelect(4);
                            }
                        });

                        function karteSelect(karteSelect){
                            $.ajax({
                            type: "GET",
                            url: "sqlKarteSelect.php" ,
                            data: {playerID: "<?php echo $playerID;?>", roomID: "<?php echo $roomID;?>", select: karteSelect},
                            success : function() { 
                                var loadGame = "gameLoad.php?playerID=".concat("<?php echo $playerID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
                                $("#spielertext").load(loadGame.concat(" #spielertext"));
                                $("#linktext").load(loadGame.concat(" #linktext"));
                                $("#spielernamenlinkfeld").load(loadGame.concat(" #spielernamenlinkfeld"));
                                $("#spielername").load(loadGame.concat(" #spielername"));
                                $("#rolle").load(loadGame.concat(" #rolle"));
                                $("#status").load(loadGame.concat(" #status"));
                                $("#host").load(loadGame.concat(" #host"));
                                $("#statistikZahlen").load(loadGame.concat(" #statistikZahlen"));
                                $("#eigenKartenZahlen").load(loadGame.concat(" #eigeneKartenZahlen"));
                                var loadMain = "gameLoadMain.php?playerID=".concat("<?php echo $playerID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
                                $("#game").load(loadMain);
                            }
                        });
                        }
                    }

                    function xmlRequest(file){
                        $.ajax({
                            type: "GET",
                            url: file ,
                            data: {playerID: "<?php echo $playerID;?>", roomID: "<?php echo $roomID;?>"},
                            success : function() { 
                                var loadGame = "gameLoad.php?playerID=".concat("<?php echo $playerID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
                                $("#spielertext").load(loadGame.concat(" #spielertext"));
                                $("#linktext").load(loadGame.concat(" #linktext"));
                                $("#spielernamenlinkfeld").load(loadGame.concat(" #spielernamenlinkfeld"));
                                $("#spielername").load(loadGame.concat(" #spielername"));
                                $("#rolle").load(loadGame.concat(" #rolle"));
                                $("#status").load(loadGame.concat(" #status"));
                                $("#host").load(loadGame.concat(" #host"));
                                $("#statistikZahlen").load(loadGame.concat(" #statistikZahlen"));
                                $("#eigenKartenZahlen").load(loadGame.concat(" #eigeneKartenZahlen"));
                                var loadMain = "gameLoadMain.php?playerID=".concat("<?php echo $playerID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
                                $("#game").load(loadMain);
                            }
                        });
                    }
                });
            </script>

        </body>
    </html>
