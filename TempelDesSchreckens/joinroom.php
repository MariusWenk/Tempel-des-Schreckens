<!DOCTYPE html>

    <?php
        $roomID = $_GET['roomID'];
        $textID = $_GET['textID'];
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
        
        <section class="zentriert" id="field"></section>
      
        <script>
            var loadJoinroom = "joinroomLoad.php?textID=".concat("<?php echo $textID;?>").concat("&roomID=").concat("<?php echo $roomID;?>");
            $("#field").load(loadJoinroom);
        </script>

        <?PHP
            
        ?>
    </body>
  </html>