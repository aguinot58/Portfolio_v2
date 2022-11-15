<?php

    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    if (!isset($_SESSION['img_projet_modif'])){
        $_SESSION['img_projet_modif'] = 'non';
    }

    require $lien.'pages/fonctions.php';
    require $lien.'pages/conn_bdd.php';

    $id_projet = $_POST["id_projet"];
    $nom_projet = str_replace("'"," ",valid_donnees($_POST["nom_projet2"]));
    $desc_projet = str_replace("'"," ",valid_donnees($_POST["desc_projet2"]));
    $typ_projet = valid_donnees($_POST["typ_projet2"]);
    $url_projet = str_replace("'"," ",valid_donnees($_POST["url_projet2"]));
    $github_projet = str_replace("'"," ",valid_donnees($_POST["github_projet2"]));
    $visibilite_projet = valid_donnees($_POST["visibilite_projet2"]);
    $comp_projet = substr(valid_donnees($_POST["comp_projet2"]),0,-2);

    if ($visibilite_projet==1){
        $visibilite_proj = 1;
    } else {
        $visibilite_proj = 0;
    }

    $img_projet = valid_donnees($_POST["img_projet3"]);
    $_SESSION['img_projet_modif'] = 'non';
    $format_img = true;

    if ($img_projet==""){
        $img_projet = valid_donnees($_FILES['img_projet2']['name']);
        $_SESSION['img_projet_modif'] = 'oui';
        if(($_FILES['img_projet2']['type']=="image/png" || $_FILES['img_projet2']['type']="image/jpg" || $_FILES['img_projet2']['type']="image/jpeg")){
            $format_img = true;
        }else{
            $format_img = false;
        }
    }

    if (!empty($nom_projet) && !empty($visibilite_projet) && !empty($url_projet) && !empty($github_projet) && !empty($desc_projet) && 
        !empty($img_projet) && !empty($typ_projet) && !empty($comp_projet) && $format_img == true && 
        strlen($nom_projet) <= 50 && strlen($url_projet) <= 255 && strlen($github_projet) <= 255 && strlen($desc_projet) <= 1000) {

        try{

            //On met à jour les données reçues dans la table jeux
            $sth = $conn->prepare("UPDATE projets set nom_proj=:nom_proj, desc_proj=:desc_proj, typ_proj=:typ_proj, langage_proj=:langage_proj, img_proj=:img_proj, 
                                            url_proj=:url_proj, url_github_proj=:url_github_proj, visibilite_proj=:visibilite_proj WHERE id_proj = :id_proj");
            $sth->bindParam(':nom_proj', $nom_projet);    
            $sth->bindParam(':desc_proj', $desc_projet);
            $sth->bindParam(':typ_proj', $typ_projet); 
            $sth->bindParam(':langage_proj', $comp_projet); 
            $sth->bindParam(':img_proj', $img_projet); 
            $sth->bindParam(':url_proj', $url_projet); 
            $sth->bindParam(':url_github_proj', $github_projet); 
            $sth->bindParam(':visibilite_proj', $visibilite_proj); 
            $sth->bindParam(':id_proj', $id_projet); 
            $sth->execute();

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;

            if ($_SESSION['img_projet_modif'] == 'oui') {

                // chemin complet de la jaquette choisie par l'utilisateur
                $file = $_FILES['img_projet2']['tmp_name'];

                // dossier de sauvegarde de l'image après traitement
                $folder_save = "./../img/";

                modifier_image($file, $_FILES['img_projet2']['name'], $folder_save, 571, 340);
            }

            $_SESSION['modif_projet'] = true;

            //On renvoie l'utilisateur vers la page d'administration des jeux
            header("Location:./../pages/back_projet.php");

        }
        catch(PDOException $e){

            //echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
            write_error_log("./../log/error_log_update_projet.txt","Impossible de mettre à jour les données.", $e);
            echo 'Une erreur est survenue, mise à jour des données annulée.';

            /*Fermeture de la connexion à la base de données*/
            $sth = null;
            $conn = null;
        }

    } else {

        echo "Merci de vérifier les informations saisies";
    
    }
?>