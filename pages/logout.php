<?php

    session_start();

    if (isset($_SESSION['Identifiant'])){
        unset($_SESSION['Identifiant']);
    }

    if (isset($_SESSION['mdp'])){
        unset($_SESSION['mdp']);
    }

    if (isset($_SESSION['logged'])){
        unset($_SESSION['logged']);
    }

    if (isset($_SESSION['user'])){
        unset($_SESSION['user']);
    }

    if (isset($_SESSION['suppr_msg'])){
        unset($_SESSION['suppr_msg']);
    }

    session_destroy();

    header("Location:back_office.php");

?>