<!DOCTYPE html>

    <?php
        include "sqlConnect.php";

        $roomID = $_GET['roomID'];
        $textID = $_GET['textID'];

        $initialisiert = mysqli_fetch_array(mysqli_query($connect,"SELECT Initialisiert FROM rooms WHERE RoomID=$roomID"))[0];
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

        <section id="field"> <?php

        if(!$initialisiert){
            echo "<h3 class=\"hide\"> Willkommen zu Tempel des Schreckens <br/></h3>";
            echo "<form action = \"sqlEnterRoom.php\" method = \"post\">";
                echo "<p>Nickname:</p>";
                echo "<p><input name =\"nickname\"/></p>";
                echo "<label><input type=\"checkbox\" class=\"language\" name=\"deutsch\" checked=\"true\"/> Deutsch</label>";
                echo "<label><input type=\"checkbox\" class=\"language\" name=\"english\"/> English</label>";
                echo "<input name=\"roomID\" value=".$roomID." hidden />";
                echo "<p>";
                echo "<input type=\"submit\" value=\"Raum ".$roomID." beitreten\"/>";
                echo "</p>";
                echo "<p>(Sprache noch nicht wirklich einstellbar)</p>";
            echo "</form>";

            if($textID == 1){
                echo "<p style=\"color: red;\">Dieser Name ist leider schon vergeben.</p>";
            }
        }else{
            echo "<h3 class=\"hide\"> Willkommen zu Tempel des Schreckens <br/></h3>";
            echo "<form action = \"sqlEnterRoomInitialisiert.php\" method = \"post\">";
                echo "<p class=\"jointext\"> In Raum ".$roomID." hat das Spiel bereits gestartet. Falls du herausgeflogen bist, gib bitte exakt den Namen ein, mit dem du angemeldet warst.</p>";
                echo "<p><input name =\"nickname\"/></p>";
                echo "<input name=\"roomID\" value=".$roomID." hidden />";
                echo "<p>";
                echo "<input type=\"submit\" value=\"Raum ".$roomID." beitreten\"/>";
                echo "</p>";
            echo "</form>";

            if($textID == 1){
                echo "<p style=\"color: red;\">Dieser Name ist leider nicht im Spiel.</p>";
            }
        }

        ?>  </section>
      
        <script>
            $("input:checkbox").on('click', function() {
            var box = $(this);
            if (box.is(":checked")) {
                var group = "input:checkbox[class='" + box.attr("class") + "']";
                $(group).prop("checked", false);
                box.prop("checked", true);
            } else {
                box.prop("checked", false);
            }
            });
        </script>

        <?PHP
            
        ?>
    </body>
  </html>