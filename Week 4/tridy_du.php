<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Základní struktura objektů v PHP</title>
</head>
<body>
<?php
// Rodicovska trida pro Studenta a Ucitele
class Osoba {
    protected $jmeno;
    protected $prijmeni;

    public function __construct($jmeno, $prijmeni) {
        $this->jmeno = $jmeno;
        $this->prijmeni = $prijmeni;
    }
}

// Trida pro Studenta
class Student extends Osoba {
    protected $cislo;

    public function __construct($jmeno, $prijmeni, $cislo) {
        parent::__construct($jmeno, $prijmeni);
        $this->cislo = $cislo;
    }
}

// Trida pro Ucitele
class Ucitel extends Osoba {
    protected $titul;

    public function __construct($jmeno, $prijmeni, $titul) {
        parent::__construct($jmeno, $prijmeni);
        $this->titul = $titul;
    }
}

// Trida pro Cviceni
class Cviceni {
    protected $studenti = [];
    protected $ucitel;
    protected $ucebna;

    public function __construct($ucitel, $ucebna) {
        $this->ucitel = $ucitel;
        $this->ucebna = $ucebna;
    }

    public function pridatStudenta(Student $student) {
        $this->studenti[] = $student;
    }
}

// Vytvoreni instance studenta
$student1 = new Student("Maksim", "Obukhov", "000001");
$student2 = new Student("Jan", "Novák", "000002");

// Vytvoreni instance ucitele
$ucitel = new Ucitel("Stanislav", "Vojíř", "Ph.D.");

// Vytvoreni instance cviceni
$cviceni = new Cviceni($ucitel, "SB207");

// Pridani studentu do cviceni
$cviceni->pridatStudenta($student1);
$cviceni->pridatStudenta($student2);

// Vypis informaci o cviceni
echo "<pre>Informace o cviceni:\n";
var_dump($cviceni);
echo "</pre>";
?>
</body>
</html>
