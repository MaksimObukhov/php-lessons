<?php
    $xmlData = '<osoby>
                    <osoba id="10">
                        <jmeno>Josef</jmeno>
                        <prijmeni>Novák</prijmeni>
                        <email>josef.novak@nekde.cz</email>
                        <email>josef.novak@nikde.com</email>
                    </osoba>
                    <osoba id="12">
                        <jmeno>Eva</jmeno>
                        <prijmeni>Adamová</prijmeni>
                    </osoba>
                </osoby>';

    $xml = simplexml_load_string($xmlData);

    foreach ($xml->osoba as $osoba){
       echo $osoba['id'].': ';
       $osoba->jmeno = 'Nikdo';
       echo $osoba->jmeno.'</br>';
    }

    echo $xml->osoba[0]['id'];
