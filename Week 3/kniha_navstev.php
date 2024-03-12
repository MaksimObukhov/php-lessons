<?php

  $errors=[];

  if (!empty($_POST)){
    //kontrola dat

    $_POST['jmeno'] = trim($_POST['jmeno'] ?? '');
    $_REQUEST['jmeno'] = $_POST['jmeno'];

    if (mb_strlen($_POST['jmeno'], 'utf-8')<5){
      $errors['jmeno']='Jmeno musi mit aspon 5 znaku';
    }

    $_POST['email'] = trim($_POST['email'] ?? '');
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      $errors['email']='Zadejte platny email';
    }

    if (mb_strlen($_POST['text'], 'utf-8')<10){
        $errors['text']='Je nutne zadat aspon 10 znaku';
    }

    if (empty($errors)){
      $text = $_POST['text'];
      $text = htmlspecialchars($text);
      $text = nl2br($text);

      $vystup = '<a href="mailto:'.htmlspecialchars($_POST['email']).'">'.htmlspecialchars($_POST['jmeno']).'</a>';
      $vystup.= '<br>';
      $vystup.= $text;
      $vystup.='<br>';
    }
    // TODO:
    // chybu zapis, presmerovani a include
    // kouknut na php objekty

  }
?><!DOCTYPE html>
<html lang="en">
  <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8">
      <title>Kniha návštěv</title>
  </head>
  <body>

    <form method="post">
      <label for="jmeno">Jmeno:</label><br>
      <input type="text" name="jmeno" id="jmeno" value="<?php echo htmlspecialchars($_REQUEST['jmeno'] ?? '')?>" /><br>
      <?php
        if (!empty($errors['jmeno'])){
          echo '<div style="color:red;">'.$errors['jmeno'].'</div>';
        }
      ?>

      <label for="email">E-mail:</label><br>
      <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($_REQUEST['email'] ?? '')?>" /><br>
      <?php
      if (!empty($errors['email'])){
          echo '<div style="color:red;">'.$errors['email'].'</div>';
      }
      ?>


      <label for="text">Text prispevku:</label><br>
      <textarea name="text" id="text"><?php echo htmlspecialchars($_POST['text'] ?? '');?></textarea><br>
      <?php
      if (!empty($errors['text'])){
          echo '<div style="color:red;">'.$errors['text'].'</div>';
      }
      ?>

      <button type="submit">Odeslat</button>
    </form>


  </body>
</html>