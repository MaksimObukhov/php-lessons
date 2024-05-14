<?php

    session_start();

    if (isset($_SESSION['nacteno'])){

        $_SESSION['nacteno']++;

    }else{
        $_SESSION['nacteno']=1;
    }

    echo 'pocet nacteni: ';
    echo $_SESSION['nacteno'];
