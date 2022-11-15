<?php

    @session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/fonctions.php';
    require $lien.'pages/conn_bdd.php';

    $nom = valid_donnees($_POST["nom"]);
    $sujet = valid_donnees($_POST["sujet"]);
    $message = valid_donnees($_POST["message"]);
    $email = valid_donnees($_POST["email"]);

    if (!empty($nom) && !empty($sujet) && !empty($message) && !empty($email) && (filter_var($email, FILTER_VALIDATE_EMAIL)) &&
        strlen($nom)<=50 && strlen($sujet)<=100 && strlen($email)<=255 && strlen($message)<=1000) {

        try{

            date_default_timezone_set('Europe/Paris');
            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
            $format1 = '%Y/%m/%d';
            $date = strftime($format1);

            //On insère une partie des données reçues dans la table utilisateur
            $sth = $conn->prepare("INSERT INTO messages (dte_msg, sujet_msg, msg_msg, nom_msg, adrMail_msg) VALUES (:date_j, :sujet, :msg, :nom, :mail)");
            $sth->bindParam(':date_j', $date); 
            $sth->bindParam(':sujet', $sujet);
            $sth->bindParam(':msg', $message); 
            $sth->bindParam(':nom', $nom);    
            $sth->bindParam(':mail', $email);
            $sth->execute();
            
            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;

            $_SESSION['envoi_message'] = true;

            //On renvoie l'utilisateur vers la page de remerciement
            header("Location:../index.php#contact");

            }
            catch(PDOException $e){
                //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
                write_error_log("./../log/error_log_gest_contact.txt","Impossible d'injecter les données.", $e);
                echo 'Une erreur est survenue, merci de réessayer ultérieurement.';

                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;
            }

    } else {
        //echo 'pb de données';
        echo 'Une erreur est survenue, merci de vérifier les informations saisies.';
    }

?>