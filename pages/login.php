<?php

    session_start();
    
    require "fonctions.php";
    require "conn_bdd.php";

    $identifiant = valid_donnees($_POST["login"]);
    $mdp = valid_donnees($_POST["password"]);

    if (empty($identifiant)) {

        $_SESSION['Identifiant'] = 'renseigne';
        header("Location:back_office.php");

    } elseif (empty($mdp)) {

        $_SESSION['mdp'] = 'renseigne';
        header("Location:back_office.php");

    } else {

        $_SESSION['Identifiant'] = 'renseigne';
        $_SESSION['mdp'] = 'renseigne';
        $_SESSION['user']= $identifiant;

        $pwd_peppered = hash_hmac("sha256", $mdp, $pepper);

        try{
                    
            //On extrait le mdp correspondant à l'identifiant
            $sth = $conn->prepare("SELECT mdp_user FROM utilisateurs where ident_user = '$identifiant'");
            $sth->execute();
            $mdp_hashed = $sth->fetchColumn();

            if (password_verify($pwd_peppered, $mdp_hashed)) {
                $_SESSION['logged'] = 'oui';

                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;

                header("Location:back_office.php");

            } else {

                $_SESSION['logged'] = 'non';

                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;

                header("Location:connexion.php");

            }

        }
        /*On capture les exceptions si une exception est lancée et on affiche
        *les informations relatives à celle-ci*/
        catch(PDOException $e){
            write_error_log("./../log/error_log_login.txt","Echec extraction mdp login.", $e);
            echo 'Une erreur est survenue, merci de réessayer ultérieurement.';
            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;
        }
    }

?>