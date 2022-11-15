<?php

    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/fonctions.php';
    require $lien.'pages/conn_bdd.php';

    $nom_projet = str_replace("'"," ",valid_donnees($_POST["nom_projet"]));
    $desc_projet = str_replace("'"," ",valid_donnees($_POST["desc_projet"]));
    $img_projet = valid_donnees($_FILES['img_projet']['name']);
    $typ_projet = valid_donnees($_POST["typ_projet"]);
    $url_projet = str_replace("'"," ",valid_donnees($_POST["url_projet"]));
    $github_projet = str_replace("'"," ",valid_donnees($_POST["github_projet"]));
    $visibilite_projet = valid_donnees($_POST["visibilite_projet"]);
    $comp_projet = substr(valid_donnees($_POST["comp_projet"]),0,-2);

    if ($visibilite_projet=="oui"){
        $visibilite_proj = 1;
    } else {
        $visibilite_proj = 0;
    }
    
    if (!empty($nom_projet) && !empty($visibilite_projet) && !empty($url_projet) && !empty($github_projet) && !empty($desc_projet) && 
        !empty($img_projet) && !empty($typ_projet) && !empty($comp_projet) &&
        ($_FILES['img_projet']['type']=="image/png" || $_FILES['img_projet']['type']="image/jpg" || $_FILES['img_projet']['type']="image/jpeg") &&
        strlen($nom_projet) <= 50 && strlen($url_projet) <= 255 && strlen($github_projet) <= 255 && strlen($desc_projet) <= 1000) {

        // chemin complet de la jaquette choisie par l'utilisateur
        $file = $_FILES['img_projet']['tmp_name'];

        // dossier de sauvegarde de l'image après traitement
        $folder_save = "./../img/";

        $identifiant = $_SESSION['user'];

            try{

                //On insère une partie des données reçues dans la table jeux
                $sth = $conn->prepare("INSERT INTO projets (nom_proj, desc_proj, typ_proj, langage_proj, img_proj, url_proj, url_github_proj, visibilite_proj) VALUES
                        (:nom_proj, :desc_proj, :typ_proj, :langage_proj, :img_proj, :url_proj, :url_github_proj, :visibilite_proj)");
                $sth->bindParam(':nom_proj', $nom_projet);    
                $sth->bindParam(':desc_proj', $desc_projet);
                $sth->bindParam(':typ_proj', $typ_projet); 
                $sth->bindParam(':langage_proj', $comp_projet); 
                $sth->bindParam(':img_proj', $img_projet); 
                $sth->bindParam(':url_proj', $url_projet); 
                $sth->bindParam(':url_github_proj', $github_projet);
                $sth->bindParam(':visibilite_proj', $visibilite_proj); 
                $sth->execute();
            
                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;

                modifier_image($file, $_FILES['img_projet']['name'], $folder_save, 571, 340);

                $_SESSION['ajout_projet'] = true;

                //On renvoie l'utilisateur vers la page d'administration des jeux
                header("Location:./../pages/back_projet.php");

            }
            catch(PDOException $e){

                //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
                write_error_log("./../log/error_log_ajout_projet.txt","Impossible d'injecter les données.", $e);
                echo 'Une erreur est survenue, injection des données annulée.';

                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;
            }

    } else {
        echo "Merci de vérifier les informations saisies";
    }

?>

