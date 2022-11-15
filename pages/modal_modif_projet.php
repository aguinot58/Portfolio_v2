<?php

    session_start();

    if(!empty($_POST) && array_key_exists("id_projet", $_POST)){

        $id_projet = $_POST['id_projet'];

        $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

        if ($curPageName == "index.php") {
            $lien = "./";
        } else {
            $lien = "./../";
        }

        require $lien.'pages/conn_bdd.php';

            try{

                $sth = $conn->prepare("SELECT * FROM projets where id_proj = $id_projet");
                $sth->execute();
                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                $projets = $sth->fetchAll(PDO::FETCH_ASSOC);

                foreach ($projets as $projet) {

                    echo '  <form class="form-ajout" method="post" enctype="multipart/form-data" onsubmit="return valider_projet2()" action="./../pages/update_projet.php">
                                <div class="row mt-4 mb-3">
                                    <div class="col">
                                        <label for="nom_projet2" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="nom_projet2" name="nom_projet2" value="'.$projet['nom_proj'].'">
                                        <div id="emailHelp" class="form-text">50 caractères maximum.</div>
                                    </div>
                                    <div class="col">
                                        <label for="typ_projet2" class="form-label">Type de projet</label>
                                        <select id="typ_projet2" class="form-select" name="typ_projet2" aria-label="Default select example">';

                                            try{

                                                //Sélectionne les valeurs dans les colonnes pour chaque entrée de la table
                                                $sth = $conn->prepare("SELECT distinct(typ_proj) FROM projets ORDER BY typ_proj ASC");
                                                $sth->execute();
                                                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                                $categories = $sth->fetchAll(PDO::FETCH_ASSOC);

                                                // on remplit la liste de sélection de type de projet
                                                foreach ($categories as $categorie) {

                                                    if ($categorie['typ_proj'] == $projet['typ_proj']){
                                                        echo '<option selected value="'.$categorie['typ_proj'].'">'.$categorie['typ_proj'].'</option>';
                                                    } else {
                                                        echo '<option value="'.$categorie['typ_proj'].'">'.$categorie['typ_proj'].'</option>';
                                                    }
                                                };
                                            }
                                            catch(PDOException $e){
                                
                                                date_default_timezone_set('Europe/Paris');
                                                setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                                                $format1 = '%A %d %B %Y %H:%M:%S';
                                                $date1 = strftime($format1);
                                                $fichier = fopen('./../log/error_log_modif_projet.txt', 'c+b');
                                                fseek($fichier, filesize('./../log/error_log_modif_projet.txt'));
                                                fwrite($fichier, "\n\n" .$date1. " - Erreur import liste des types de projets. Erreur : " .$e);
                                                fclose($fichier);
                            
                                                //Fermeture de la connexion à la base de données
                                                $sth = null;
                                                $conn = null;    
                                            }

                                echo    '</select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="url_projet2" class="form-label">Adresse web</label>
                                        <input type="text" class="form-control" id="url_projet2" name="url_projet2" value="'.$projet['url_proj'].'">
                                        <div id="emailHelp" class="form-text">255 caractères maximum.</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="github_projet2" class="form-label">Lien GitHub</label>
                                        <input type="text" class="form-control" id="github_projet2" name="github_projet2" value="'.$projet['url_github_proj'].'">
                                        <div id="emailHelp" class="form-text">255 caractères maximum.</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="desc_projet2" class="form-label">Description</label>
                                        <textarea type="text" class="form-control" id="desc_projet2" name="desc_projet2" rows="5">'.$projet['desc_proj'].'</textarea>
                                        <div id="emailHelp" class="form-text">1000 caractères maximum.</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div id="input_file" class="d-none row">
                                            <label for="img_projet2" class="form-label">Image</label>
                                            <div class="col">
                                                <input class="form-control" type="file" id="img_projet2" name="img_projet2">
                                            </div>
                                        </div>
                                        <div id="input_text" class="row">
                                            <label for="img_projet3" class="form-label">Image</label>
                                            <div class="col">
                                                <input type="text" class="form-control" id="img_projet3" name="img_projet3" value="'.$projet['img_proj'].'">
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-primary" id="btn-modif-contenu" onclick="Modif_contenu_page()">Modifier</button>
                                            </div>
                                        </div>
                                        <div id="emailHelp" class="form-text">Pas d\'apostrophe dans le nom - remplacer les espaces par des underscores - format jpg/jpeg/png.</div>
                                    </div>
                                </div>
                                <div class="row mb-3">    
                                    <div class="col">
                                        <label for="visibilite_projet2" class="form-label">Projet visible sur portfolio</label>
                                        <select id="visibilite_projet2" class="form-select" name="visibilite_projet2" aria-label="Default select example">';

                                            if ($projet['visibilite_proj']==1){
                                                echo    '<option selected value=1>Oui</option>
                                                        <option value=2>Non</option>';
                                            } else {
                                                echo    '<option value=1>Oui</option>
                                                        <option selected value=2>Non</option>';
                                            }

                                echo '  </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="langage_projet" class="form-label">Langages</label>
                                    <div class="mb-2">
                                        <div class="col-12">
                                            <div class="form-group form-check-inline">';
                                                $listeComp = "";
                                                if (stripos($projet['langage_proj'],"HTML")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_html2" id="chk_html2" value="HTML" checked>
                                                        <label class="form-check-label" for="chk_html2">HTML</label>';
                                                        $listeComp = $listeComp."HTML / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_html2" id="chk_html2" value="HTML">
                                                        <label class="form-check-label" for="chk_html2">HTML</label>';
                                                }
                                                if (stripos($projet['langage_proj'],"CSS")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_css2" id="chk_css2" value="CSS" checked>
                                                        <label class="form-check-label" for="chk_css2">CSS</label>';
                                                        $listeComp = $listeComp."CSS / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_html" id="chk_css2" value="CSS">
                                                        <label class="form-check-label" for="chk_css2">CSS</label>';
                                                }
                                                if (stripos($projet['langage_proj'],"BOOTSTRAP")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_boot2" id="chk_boot2" value="BOOTSTRAP" checked>
                                                        <label class="form-check-label" for="chk_boot2">BOOTSTRAP</label>';
                                                        $listeComp = $listeComp."BOOTSTRAP / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_boot2" id="chk_boot2" value="BOOTSTRAP">
                                                        <label class="form-check-label" for="chk_boot2">BOOTSTRAP</label>';
                                                }
                                                if (stripos($projet['langage_proj'],"SASS")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_sass2" id="chk_sass2" value="SASS" checked>
                                                        <label class="form-check-label" for="chk_sass2">SASS</label>';
                                                        $listeComp = $listeComp."SASS / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_sass2" id="chk_sass2" value="SASS">
                                                        <label class="form-check-label" for="chk_sass2">SASS</label>';
                                                }
                                                if (stripos($projet['langage_proj'],"LESS")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_less2" id="chk_less2" value="LESS" checked>
                                                        <label class="form-check-label" for="chk_less2">LESS</label>';
                                                        $listeComp = $listeComp."SASS / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_less2" id="chk_less2" value="LESS">
                                                        <label class="form-check-label" for="chk_less2">LESS</label>';
                                                }
                                    echo '  </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group form-check-inline">';
                                                if (stripos($projet['langage_proj'],"JS")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_js2" id="chk_js2" value="JS" checked>
                                                        <label class="form-check-label" for="chk_js2">JS</label>';
                                                        $listeComp = $listeComp."JS / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_js2" id="chk_js2" value="JS">
                                                        <label class="form-check-label" for="chk_js2">JS</label>';
                                                }
                                                if (stripos($projet['langage_proj'],"JQuery")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_jquery2" id="chk_jquery2" value="JQuery" checked>
                                                        <label class="form-check-label" for="chk_jquery2">JQuery</label>';
                                                        $listeComp = $listeComp."JQuery / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_jquery2" id="chk_jquery2" value="JQuery">
                                                        <label class="form-check-label" for="chk_jquery2">JQuery</label>';
                                                }
                                                if (stripos($projet['langage_proj'],".BAT")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_bat2" id="chk_bat2" value=".BAT" checked>
                                                        <label class="form-check-label" for="chk_bat2">.BAT</label>';
                                                        $listeComp = $listeComp.".BAT / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_bat2" id="chk_bat2" value=".BAT">
                                                        <label class="form-check-label" for="chk_bat2">.BAT</label>';
                                                }  
                                    echo '  </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group form-check-inline">';
                                                if (stripos($projet['langage_proj'],"PHP")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_php2" id="chk_php2" value="PHP" checked>
                                                        <label class="form-check-label" for="chk_php2">PHP</label>';
                                                        $listeComp = $listeComp."PHP / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_php2" id="chk_php2" value="PHP">
                                                        <label class="form-check-label" for="chk_php2">PHP</label>';
                                                }
                                                if (stripos($projet['langage_proj'],"SYMFONY")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_symfony2" id="chk_symfony2" value="SYMFONY" checked>
                                                        <label class="form-check-label" for="chk_symfony2">SYMFONY</label>';
                                                        $listeComp = $listeComp."SYMFONY / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_symfony2" id="chk_symfony2" value="SYMFONY">
                                                        <label class="form-check-label" for="chk_symfony2">SYMFONY</label>';
                                                } 
                                                if (stripos($projet['langage_proj'],"VUE.JS")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_vue2" id="chk_vue2" value="VUE.JS" checked>
                                                        <label class="form-check-label" for="chk_vue2">VUE.JS</label>';
                                                        $listeComp = $listeComp."SYMFONY / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_vue2" id="chk_vue2" value="VUE.JS">
                                                        <label class="form-check-label" for="chk_vue2">VUE.JS</label>';
                                                } 
                                    echo '  </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group form-check-inline">';
                                                if (stripos($projet['langage_proj'],"MySQL")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_js2" id="chk_js2" value="MySQL" checked>
                                                        <label class="form-check-label" for="chk_js2">MySQL</label>';
                                                        $listeComp = $listeComp."MySQL / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_mysql2" id="chk_mysql2" value="MySQL">
                                                        <label class="form-check-label" for="chk_mysql2">MySQL</label>';
                                                }
                                                if (stripos($projet['langage_proj'],"SQLite")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_sqlite2" id="chk_sqlite2" value="SQLite" checked>
                                                        <label class="form-check-label" for="chk_sqlite2">SQLite</label>';
                                                        $listeComp = $listeComp."SQLite / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_sqlite2" id="chk_sqlite2" value="SQLite">
                                                        <label class="form-check-label" for="chk_sqlite2">SQLite</label>';
                                                }
                                                if (stripos($projet['langage_proj'],"MariaDb")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_maria2" id="chk_maria2" value="MariaDb" checked>
                                                        <label class="form-check-label" for="chk_maria2">MariaDb</label>';
                                                        $listeComp = $listeComp."MariaDb / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_maria2" id="chk_maria2" value="MariaDb">
                                                        <label class="form-check-label" for="chk_maria2">MariaDb</label>';
                                                }
                                                if (stripos($projet['langage_proj'],"Informix")!==false){
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_informix2" id="chk_informix2" value="Informix" checked>
                                                        <label class="form-check-label" for="chk_informix2">Informix</label>';
                                                        $listeComp = $listeComp."Informix / ";
                                                } else {
                                                    echo'<input class="form-check-input" type="checkbox" name="chk_informix2" id="chk_informix2" value="Informix">
                                                        <label class="form-check-label" for="chk_informix2">Informix</label>';
                                                }
                                    echo '  </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <textarea type="text" class="form-control" id="comp_projet2" name="comp_projet2" rows="2" readonly>'.$listeComp.'</textarea>
                                    </div>
                                </div>                               
                                <div class="col-1">
                                        <label for="id_projet" class="invisible">Id du projet</label>
                                        <input type="text" class="form-control invisible" id="id_projet" name="id_projet" value="'.$id_projet.'">
                                    </div>
                                    <div class="d-flex justify-content-center"">
                                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                    </div>
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
                $fichier = fopen('./../log/error_log_modif_projet.txt', 'c+b');
                fseek($fichier, filesize('./../log/error_log_modif_projet.txt'));
                fwrite($fichier, "\n\n" .$date1. " - Erreur import données projet. Erreur : " .$e);
                fclose($fichier);

                /*Fermeture de la connexion à la base de données*/
                $sth = null;
                $conn = null;    

            }

    }else{
        echo 'pb id_projet';
    }

?>