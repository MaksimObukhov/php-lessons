<?php

    session_start();

    require_once __DIR__ .'/../db.php';

    if(!empty($_POST['email'])){
        //zkusime najit uzivatele
        $query=$db->prepare('SELECT * FROM uzivatele WHERE email=:email LIMIT 1;');
        $query->execute([
            ':email'=>$_POST['email']
        ]);

        $rows=$query->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($rows)){

            $uzivatelDb=$rows[0];
            if (password_verify($_POST['heslo'], $uzivatelDb['heslo'])){
                //prihlaseni
                $_SESSION['uzivatel_id']=$uzivatelDb['id'];
                $_SESSION['uzivatel_email']=$uzivatelDb['email'];

                header('Location: index.php');
            }

        }

    }

?><!DOCTYPE HTML>
<html>
<head>
    <meta>
    <title>Prihlaseni - Moje aplikace</title>
</head>
<body>

    <form method="post">
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" value="" required /><br>

        <label for="heslo">Heslo:</label><br>
        <input type="password" name="heslo" id="heslo" value="" required /><br>

        <button type="submit">Prihlasit se</button>
    </form>

</body>

</html>