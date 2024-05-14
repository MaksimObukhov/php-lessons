<?php

    session_start();

?><!DOCTYPE HTML>
<html>
    <head>
        <meta>
        <title>Moje aplikace</title>
    </head>
    <body>

      <?php

        if (!empty($_SESSION['uzivatel_id'])){
          echo 'Prihlasen uzivatel: '.$_SESSION['uzivatel_id'].', ';
          echo htmlspecialchars($_SESSION['uzivatel_email']);

          echo '<br>
                <a href="logout.php">Odhlasit se</a>';

        }else{

          echo '<a href="login.php">Prihlasit se</a>';

        }

      ?>

    </body>

</html>