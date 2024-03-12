<?php

/**
 * Class Osoba - zakladni trida pro jednotlive osoby
 * @author Maksim Obukhov
 */
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