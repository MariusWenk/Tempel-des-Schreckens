<!DOCTYPE html>

    <!-- 
        Verbessern:
        -Link in Zwischenablage kopieren
        -Geeigneten Server erstellen
        -beliebige Bildschitmformate
        -Sprachen
        -Git, Docker
        -Spieler verlässt Spiel
        -generischere Knopfbefehle
        -Regeln anzeigen
        -Daten verschlüsseln
        -Bilder Rechte
    -->


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

            <p id="load"></p>

            <section id="link" class="anzeige button">
                <p id="linktext" class="button">Anzahl Spieler: <?php echo $spielerAnzahl?></p>
            </section>

            <section id="spieleranzeige" class="anzeige button">
                <p id="spielertext" class="button"><?php echo $name[$playerID]." - ".$role[$playerID];?></p>
            </section>

            <section class="button" id="linkfeld">
                <h3 class="button">Spieler mit diesem Link einladen</h3>
                <p class="button" id="linkstring"><?php echo $linkstring.$roomID;?></p>
                <section class="anzeige button" id="linkbutton">
                    <p class="button">Link in Zwischenablage kopieren</p>
                </section>
                <h3 class="button">Spieler:</h3>
                <h4 class="button" id="spielernamenlinkfeld">
                    <?php foreach($name as $key => $value){
                        echo $value;
                        if($status[$key] == "Host"){
                            echo " - Host";
                        }
                        if($AmZug[$key] && $initialisiert){
                            echo " - Am Zug";
                        }
                        echo "</br>";
                    }?></h4>
            </section>

            <section class="button" id="spielerfeld">
                <h3 class="button" id="spielername">Einegeloggt als: <?php echo $name[$playerID];?></h3>
                <h3 class="button">Rolle: <?php echo $role[$playerID];?></h3>
                <h3 class="button">Status: <?php echo $status[$playerID];?></h3>
                <p class="button"><input id="newName" value="<?php echo $name[$playerID];?>" class="button"/></p>
                <section class="anzeige button spielerbutton" id="spielerbutton1">
                    <p class="button">Namen ändern</p>
                </section>
                <section class="anzeige button spielerbutton" id="spielerbutton2">
                    <p class="button"><?php 
                        if($status[$playerID] == "Host"){
                            echo "Hostrechte abgeben";
                        }
                    ?></p>
                </section>
            </section>

            <section id="statistik">
                <h3>Gefundene Karten:</h3>
                <img src="Statistik.PNG" width="500px" height="10%">
                <h3 id="statistikZahlen" class="statistikzahlen"> <?php echo $emptyDisc."/".$emptyGen;?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $treasureDisc."/".$treasureGen;?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo $trapDisc."/".$trapGen;?></h3>
            </section>

            <section id="game" class="gameA"></section>

            <section id="ownCards">
                <h3>Eigene Karten:</h3>
                <img src="Statistik.PNG" width="500px" height="10%">
                <h3 id="eigeneKartenZahlen" class="statistikzahlen"> <?php echo $empty[$playerID];?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $treasure[$playerID];?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php echo $trap[$playerID];?></h3>
            </section>
        
            <script>
                var loadMain = "gameLoadMain.php?playerID=".concat("<?php echo $playerID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
                $("#game").load(loadMain);
                $(document).ready(function(){
                    if("<?php echo $spielerMenu;?>" == "0"){
                        $("#spielerfeld").hide();
                    }
                    if("<?php echo $linkMenu;?>" == "0"){
                        $("#linkfeld").hide();
                    }

                    $("html").click(function(e){
                        var container = $(".button");
                        if (!container.is(e.target) && container.has(e.target).length === 0) 
                        {
                            $("#linkfeld").hide();
                            $("#spielerfeld").hide();
                            xmlRequestMenus("sqlUpdateWindows.php","0","0");
                        }
                    });
                    $("#link").click(function(){
                        $("#linkfeld").show();
                        xmlRequestMenus("sqlUpdateWindows.php","<?php echo $spielerMenu;?>","1");
                    });
                    $("#spieleranzeige").click(function(){
                        $("#spielerfeld").show();
                        xmlRequestMenus("sqlUpdateWindows.php","1","<?php echo $linkMenu;?>");
                    });
                    $("#linkbutton").click(function(){
                        copyToClipboard("#linkstring");
                    });
                    $("#spielerbutton1").click(function(){
                        var newName = document.getElementById("newName").value;
                        document.location.href = "sqlChangeName.php?newName=".concat(newName).concat("&playerID=").concat("<?php echo $playerID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
                    });
                    $("#spielerbutton2").click(function(){
                        document.location.href = "sqlUpdateHost.php?playerID=".concat("<?php echo $playerID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
                    });
                    $("#newName").click(function(){
                        selectText("newName");
                    });

                    function xmlRequestMenus(file, spM, liM){
                        
                        $.ajax({
                            type: "GET",
                            url: file ,
                            data: {playerID: "<?php echo $playerID;?>", roomID: "<?php echo $roomID;?>", spielerMenu: spM, linkMenu: liM },
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
                            }
                        });
                    }

                    function copyToClipboard(element) {
                        var str = $(element).text();
                        var data = [new ClipboardItem({ "text/plain": new Blob([str], { type: "text/plain" }) })];
                        navigator.clipboard.write(data);
                    }
                    function selectText(id) {
                        const input = document.getElementById(id);
                        input.focus();
                        input.select();
                    }
                });
                setInterval(function(){
                    var loadVariables = "gameVariables.php?playerID=".concat("<?php echo $playerID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
                    $("#load").load(loadVariables);

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
                }, 5000);
                setInterval(function(){
                    $("#fehlerStart").empty();
                }, 5000);
            </script>

        </body>
    </html>
