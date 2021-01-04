<!DOCTYPE html>

    <?php
        include "sqlConnect.php";

        $roomID = $_GET['roomID'];
        $playerID = $_GET['playerID'];

        $updateNecessary = mysqli_fetch_array(mysqli_query($connect,"SELECT UpdateNecessary FROM players WHERE RoomID=$roomID AND PlayerID=$playerID"))[0];
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

            <p id="updateNecessary"><?php echo $updateNecessary?></p>

        </body>
    </html>
