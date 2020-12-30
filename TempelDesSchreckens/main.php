<!DOCTYPE html>
  <html lang="de">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <head>
      <Title>Tempel des Schreckens</Title>

      <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

      <link rel="stylesheet" type="text/CSS" href="main.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    
    <body>
        <section class="zentriert">
            <h3 class="hide"> Willkommen zu Tempel des Schreckens <br/></h3>
            <form action = "sqlInitializeRoom.php" method = "post">
                <p>Nickname:</p>
                <p><input name ="nickname"/></p>
                <label><input type="checkbox" class="language" name="deutsch" checked="true"/> Deutsch</label>
                <label><input type="checkbox" class="language" name="english"/> English</label>
                <p>
                <input type="submit" value="Raum erstellen"/>
                </p>
             </form>
        </section>
      
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