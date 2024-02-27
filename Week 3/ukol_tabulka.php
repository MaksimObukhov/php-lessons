<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Tabulka</title>
</head>
<body>
<?php

    $radky = (int)($_GET['radky'] ?? 0);
    $sloupce = (int)($_GET['sloupce'] ?? 0);

    if ($radky > 0 && $sloupce > 0){

        $cislo = 1;

        echo '<table border="1">';
        for ($r=0; $r<$radky; $r++){
            echo '<tr>';
            for ($s=0; $s < $sloupce; $s++) {
                echo '<td>'.$cislo.'</td>';
                $cislo++;
            }
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "Zadejte pocet radku a sloupcu";
    }
?>
</body>
</html>
