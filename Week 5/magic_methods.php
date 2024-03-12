<?php

    class Osoba {

        public string $jmeno;
        public string $prijmeni;

        public function __construct(string $jmeno, string $prijmeni) {
            $this->jmeno = $jmeno;
            $this->prijmeni = $prijmeni;
        }

        public function __toString():string {
            return $this->jmeno.' '.$this->prijmeni;
        }

    }

    $pepa = new Osoba('Josef', 'Novak');

    $franta = clone $pepa;
    $franta->jmeno = 'Frantisek';

    echo $pepa;
    echo '<br />';
    echo $franta;

    $str = serialize($pepa);
    echo '<br />'.$str;

    $pepa2 = unserialize($str);
    echo '<br />'.$pepa2;
    var_dump($pepa2);

    echo '<br />'.json_encode($pepa);



