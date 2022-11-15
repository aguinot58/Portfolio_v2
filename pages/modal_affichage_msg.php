<?php

    session_start();

    if(!empty($_POST) && array_key_exists("id_msg", $_POST)){

        $id_msg = $_POST['id_msg'];

        $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

        if ($curPageName == "index.php") {
            $lien = "./";
        } else {
            $lien = "./../";
        }

        require $lien.'pages/conn_bdd.php';

            try{

                $sth = $conn->prepare("SELECT * FROM messages WHERE id_msg = :id_msg");
                $sth->bindParam(':id_msg', $id_msg);
                $sth->execute();
                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                $messages = $sth->fetchAll(PDO::FETCH_ASSOC);

                foreach ($messages as $message) {

                    echo '  <form class="form-ajout" method="post" enctype="multipart/form-data" onsubmit="" action="">

                                <div class="row mt-1 mb-3">
                                    <div class="col">
                                        <label for="id_msg" class="form-label">Id : </label>
                                        <label class="form-label">'.$message['id_msg'].'</label>
                                        <input type="text" class="form-control d-none" id="id_msg" name="id_msg" value="'.$message['id_msg'].'">
                                    </div>
                                    <div class="col">
                                        <label for="dte_msg" class="form-label">Date : </label>
                                        <label class="form-label">'.$message['dte_msg'].'</label>
                                        <input type="text" class="form-control d-none" id="dte_msg" name="dte_msg" value="'.$message['dte_msg'].'">
                                    </div>
                                </div>
                                <div class="row mt-1 mb-3">
                                    <div class="col">
                                        <label for="nom_msg" class="form-label">Nom : </label>
                                        <label class="form-label">'.$message['nom_msg'].'</label>
                                        <input type="text" class="form-control d-none" id="nom_msg" name="nom_msg" value="'.$message['nom_msg'].'">
                                    </div>
                                    <div class="col">
                                        <label for="sujet_msg" class="form-label">Sujet : </label>
                                        <label class="form-label">'.$message['sujet_msg'].'</label>
                                        <input type="text" class="form-control d-none" id="sujet_msg" name="sujet_msg" value="'.$message['sujet_msg'].'">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="mail_msg" class="form-label">Adresse E-mail : </label>
                                        <label class="form-label">'.$message['adrMail_msg'].'</label>
                                        <input type="text" class="form-control d-none" id="mail_msg" name="mail_msg" value="'.$message['adrMail_msg'].'">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="msg_msg" class="form-label">Message : </label>
                                        <label class="form-label">'.$message['msg_msg'].'</label>
                                        <textarea type="text" class="form-control d-none" id="msg_msg" name="msg_msg">'.$message['msg_msg'].'</textarea>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-primary" href="mailto:'.$message['adrMail_msg'].'?subject=Re:%20'.$message['sujet_msg'].'" target="_blank">Répondre</a>
                                </div>
                            </form>';

                    /*Fermeture de la connexion à la base de données*/
                    $sth = null;
                    $conn = null;

                    break;

                }

            }
            catch(PDOException $e){                
                date_default_timezone_set('Europe/Paris');
                setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                $format1 = '%A %d %B %Y %H:%M:%S';
                $date1 = strftime($format1);
                $fichier = fopen('./../log/error_log_modal_consult_msg.txt', 'c+b');
                fseek($fichier, filesize('./../log/error_log_modal_consult_msg.txt'));
                fwrite($fichier, "\n\n" .$date1. " - Erreur import données message. Erreur : " .$e);
                fclose($fichier);

                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;    
            }

    }else{
        echo 'pb id_msg';
    }

?>