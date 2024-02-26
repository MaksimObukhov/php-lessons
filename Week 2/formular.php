<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Domácí úkol - data od uživatele</title>
</head>
<body>

<h1>Testovací formulář</h1>

<form method="get">
    <label for="jmeno">Jméno a příjmení</label><br />
    <input type="text" id="jmeno" name="jmeno" value="" /><br />

    <label for="poznamka">Poznámka (10-20 znaků)</label><br />
    <input type="text" name="poznamka" id="poznamka" value=""><br />

    <button type="submit">odeslat</button>
</form>

<h2>Testovací odkaz</h2>

<a href="formular.php?jmeno=Čížek&poznamka=ahd%20d">Testovací odkaz s parametry</a>

<h2>Vyhodnocení</h2>

<?php

if (empty($_GET)){
    echo 'nebyla odeslána žádná data';
}else{

    // 1.
    if (!isset($_GET['jmeno'])) {
        echo '<p>Nebylo zadáno jméno a příjmení.</p>';
        exit;
    }

    $jmeno = trim($_GET['jmeno']);
    if (empty($jmeno) || strpos($jmeno, ' ') === false) {
        echo '<p>Jméno a příjmení musí obsahovat mezeru.</p>';
        exit;
    }

    // 2.
    $poznamka = $_GET['poznamka'];
    $poznamka_delka = mb_strlen($poznamka);
    if ($poznamka_delka < 10 || $poznamka_delka > 20) {
        echo '<p>Délka poznámky musí být mezi 10 a 20 znaky.</p>';
        exit;
    }

    // 3.
    $poznamka_bez_mezer = str_replace(' ', '', $poznamka);

    // 4.
    echo '<table>
                <tr>
                  <th>Jméno a příjmení</th>
                  <td>' . htmlspecialchars($jmeno) . '</td>
                </tr>
                <tr>
                  <th>Poznámka</th>
                  <td>' . htmlspecialchars($poznamka) . '</td>
                </tr>
                <tr>
                  <th>Poznámka po převedení na malá písmena, bez mezer</th>
                  <td>' . htmlspecialchars(mb_strtolower($poznamka_bez_mezer)) . '</td>
                </tr>
              </table>';
}
?>
</body>
</html>
