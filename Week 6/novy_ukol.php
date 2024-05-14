<?php

    require __DIR__ . '/db.php';

    if (!empty($_POST['nazev'])){
        $nazev = trim($_POST['nazev']);
        if (!empty($nazev)){
            //ulozeni do DB
            $insert = $db->prepare('INSERT INTO ukoly(nazev,kategorie,stav)
                                            VALUES (:nazev, :kategorie, "new")');
            $insert->execute([

                ':nazev'=>$nazev,
                ':kategorie'=>!empty($_POST['kategorie'])?$_POST['kategorie']:null

            ]);

            header('Location: db_hodina.php');
        }
    }

?><!DOCTYPE HTML>
<html>
<head>
    <title>Novy ukol</title>
</head>
<body>

<form method="post">
    <label for="nazev">Nazev ukolu</label>
    <input type="text" name="nazev" id="nazev" required />
    <br>

    <label for="kategorie">Kategorie:</label>
    <select name="kategorie" id="kategorie">
        <option value="">--nezadano--</option>

        <?php

            $query=$db->query('SELECT * FROM kategorie ORDER BY nazev;');
            $kategorie = $query->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($kategorie)){
                foreach($kategorie as $k){

                    echo '<option value="'.$k['id'].'"
                        '.(!empty($_REQUEST['kategorie'])&&$_REQUEST['kategorie']==$k['id']
                            ? ' selected':''
                        ).'
                    >'.htmlspecialchars($k['nazev']).'</option>';

                }
            }

        ?>

    </select>
    <br>

    <button type="submit">ulozit</button>
</form>

</body>
</html>
