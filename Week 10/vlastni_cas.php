<?php

    $ted = new DateTime();
    $datumNarozeni = new DateTime("2001-12-22");

    $aktualniVek = $ted->diff($datumNarozeni);
    var_dump($aktualniVek);
