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

            <p id="linktext">Anzahl Spieler: <?php echo $spielerAnzahl?></p>

            <p id="spielertext"><?php echo $name[$playerID]." - ".$role[$playerID];?></p>

            <p id="spielernamenlinkfeld">
                <?php foreach($name as $key => $value){
                    echo $value;
                    if($status[$key] == "Host"){
                        echo " - Host";
                    }
                    if($AmZug[$key] && $initialisiert){
                        echo " - Am Zug";
                    }
                    echo "</br>";
                }?>
            </p>

            <p id="spielername">Einegeloggt als: <?php echo $name[$playerID];?></p>
                
            <p id="rolle">Rolle: <?php echo $role[$playerID];?></p>
                
            <p id="status">Status: <?php echo $status[$playerID];?></p>
                
            <!-- <p><input id="newName" value="<?php //echo $name[$playerID];?>" class="button"/></p> -->
                  
            <p id="host"><?php 
                if($status[$playerID] == "Host"){
                    echo "Hostrechte abgeben";
                }
            ?></p>

            <p id="statistikZahlen"> <?php echo $emptyDisc."/".$emptyGen;?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $treasureDisc."/".$treasureGen;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo $trapDisc."/".$trapGen;?></p>

            <p id="eigeneKartenZahlen"> <?php echo $empty[$playerID];?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $treasure[$playerID];?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo $trap[$playerID];?></p>

        </body>
    </html>
