<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Úkoly</title>
</head>
<body>

<?php

require 'db.php';
/** @var \PDO $db */

if (!empty($_GET['stav'])){
    //filtrujeme ukoly podle stavu
    $query=$db->prepare('SELECT ukoly.*,kategorie.nazev AS nazevkategorie 
                                FROM ukoly LEFT JOIN kategorie ON
                                ukoly.kategorie=kategorie.id 
                                WHERE stav=?;');
    $query->execute([
        $_GET['stav']
    ]);

}else{
    //chceme vsechny ukoly
    $query = $db->query('SELECT ukoly.*,kategorie.nazev AS nazevkategorie 
                                FROM ukoly LEFT JOIN kategorie
                                ON ukoly.kategorie=kategorie.id;');

}

//ziskame vysledky do pole
$ukoly = $query->fetchAll(PDO::FETCH_ASSOC);

//vypiseme ukoly
if (!empty($ukoly)){
    echo '<ul>';

    foreach ($ukoly as $ukol){
        echo '<li>'.htmlspecialchars($ukol['nazev']);
        if ($ukol['kategorie']>0){
          echo ' ('.htmlspecialchars($ukol['nazevkategorie']).')';
        }
        echo '</li>';
    }

    echo '</ul>';
}




?>




</body>
</html>
