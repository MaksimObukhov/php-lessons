<?php
// Cesta k souboru CSV
$csvFilePath = 'adresar.csv';

// Načtení zaměstnanců z CSV souboru
function nactiZamestnance($filename) {
    $handle = fopen($filename, "r");
    $zamestnanci = [];
    if ($handle !== FALSE) {
        // Přeskočení hlavičky
        fgetcsv($handle, 1000, ";");
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $zamestnanci[] = $data;
        }
        fclose($handle);
    }
    return $zamestnanci;
}

// Přidání zaměstnance do CSV souboru
function pridejZamestnance($filename, $zamestnanec) {
    $handle = fopen($filename, 'a');
    if ($handle !== FALSE) {
        fputcsv($handle, $zamestnanec, ';');
        fclose($handle);
    }
}

// Zpracování formuláře pro přidání zaměstnance
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novyZamestnanec = [
        $_POST['jmeno'], $_POST['prijmeni'], '', '', $_POST['obec'], $_POST['psc'], '', '', 'dělník', $_POST['nadrizeny']
    ];
    pridejZamestnance($csvFilePath, $novyZamestnanec);
}

// Zobrazení zaměstnanců
function zobrazZamestnance($zamestnanci) {
    echo '<table border="1"><tr><th>Jméno</th><th>Příjmení</th><th>Obec</th><th>PSČ</th><th>Pozice</th><th>Nadřízený</th></tr>';
    foreach ($zamestnanci as $zamestnanec) {
        echo '<tr>';
        foreach ([0, 1, 4, 5, 8, 9] as $index) {
            echo '<td>'.htmlspecialchars($zamestnanec[$index]).'</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

$zamestnanci = nactiZamestnance($csvFilePath);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Seznam zaměstnanců</title>
</head>
<body>
<h2>Přidat zaměstnance</h2>
<form method="post">
    Jméno: <input type="text" name="jmeno" required><br>
    Příjmení: <input type="text" name="prijmeni" required><br>
    Obec: <input type="text" name="obec" required><br>
    PSČ: <input type="text" name="psc" required><br>
    Nadřízený: <input type="text" name="nadrizeny"><br>
    <input type="submit" value="Přidat">
</form>

<h2>Seznam zaměstnanců</h2>
<?php zobrazZamestnance($zamestnanci); ?>
</body>
</html>
