<?php

    session_start();

    require_once __DIR__ .'/../db.php';
if(!empty($_POST)){
    //uzivatel neco poslal

    $chyby=[];
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $chyby[]='Musite zadat platny e-mail.';
    }else{
        //kontrola vuci DB
        $query=$db->prepare('SELECT * FROM uzivatele WHERE email=:email LIMIT 1;');
        $query->execute([
            ':email'=>$_POST['email']
        ]);
        $rows=$query->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($rows)){
            $chyby[]='Uzivatel s danym emailem je jiz registrovan.';
        }
    }

    if (empty($_POST['heslo']) || (mb_strlen($_POST['heslo'], 'utf-8') < 5)){
      $chyby[]='Musite zadat heslo o delce aspon 5 znaku.';
    }elseif(empty($_POST['heslo2']) || ($_POST['heslo']!=$_POST['heslo2'])){
      $chyby[]='Zadana hesla se neshoduji.';
    }

    if (empty($chyby)){
      //save
      $query=$db->prepare('INSERT INTO uzivatele(email,heslo) VALUES(:email,:heslo);');
      $query->execute([
          ':email'=>$_POST['email'],
          ':heslo'=>password_hash($_POST['heslo'],PASSWORD_DEFAULT)
      ]);

        //login and redirect
      $query=$db->prepare('SELECT * FROM uzivatele WHERE email=:email LIMIT 1;');
      $query->execute([
          ':email'=>$_POST['email']
      ]);

      $rows=$query->fetchAll(PDO::FETCH_ASSOC);
      if (!empty($rows)){

          $uzivatelDb=$rows[0];
          $_SESSION['uzivatel_id']=$uzivatelDb['id'];
          $_SESSION['uzivatel_email']=$uzivatelDb['email'];

      }


      header('Location: index.php');
    }

}


?><!DOCTYPE HTML>
<html>
<head>
    <meta>
    <title>Registrace - Moje aplikace</title>
</head>
<body>

    <form method="post">

      <?php

        if (!empty($chyby)){
          echo '<div style="color:red;">'.implode('<br>', $chyby).'</div>';
        }

      ?>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" value="" required /><br>

        <label for="heslo">Heslo:</label><br>
        <input type="password" name="heslo" id="heslo" value="" required /><br>

        <label for="heslo2">Heslo:</label><br>
        <input type="password" name="heslo2" id="heslo2" value="" required /><br>

        <button type="submit">Zaregistrovat se</button>
    </form>

</body>

</html>