<?php

    spl_autoload_register(function(string $className):bool {
        $filename = strtolower($className).'.php';
        $filename = __DIR__.'/'.$filename;

        if (file_exists($filename)) {
            include $filename;
            return true;
        }
        return false;
    });

    $pepa = new Osoba('Josef', 'Novak');

    echo serialize($pepa);
    echo '<br />'.json_encode($pepa);