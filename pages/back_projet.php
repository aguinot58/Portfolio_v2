<?php

    session_start();

    if (!isset($_SESSION['logged'])){
        $_SESSION['logged'] = 'non';
    }

    if (!isset($_SESSION['modif_projet'])){
        $_SESSION['modif_projet'] = false;
    }

    if ($_SESSION['modif_projet']== true){
        ?>
            <script type="text/javascript">
                alert ("Projet modifié avec succès !");
            </script>
        <?php
        $_SESSION['modif_projet']= false;
    }

    if (!isset($_SESSION['suppr_jeu'])){
        $_SESSION['suppr_jeu'] = false;
    }

    if ($_SESSION['suppr_jeu']== true){
        ?>
            <script type="text/javascript">
                alert ("Jeu supprimé avec succès !");
            </script>
        <?php
        $_SESSION['suppr_jeu']= false;
    }

    if (!isset($_SESSION['ajout_projet'])){
        $_SESSION['ajout_projet'] = false;
    }

    if ($_SESSION['ajout_projet']== true){
        ?>
            <script type="text/javascript">
                alert ("Projet ajouté avec succès !");
            </script>
        <?php
        $_SESSION['ajout_projet']= false;
    }

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    $niv_admin = $_SESSION['niv_admin'];

?>
    
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Admin_projets_Portfolio Aymeric Guinot</title>
        <link rel="shortcut icon" type="image/ico" href="./../img/icon.png">
    
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>   
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        </style>
        <link rel="stylesheet" href="./../css/back.css"/>
    
    </head>

    <body>

        <header>
            <!-- Fixed navbar -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="./../index.php">Portfolio</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?PHP

                    if ($_SESSION['logged'] == 'oui') {

                        echo '<div class="collapse navbar-collapse" id="navbarCollapse">
                            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="./../pages/back_office.php">Accueil Admin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="./../pages/back_projet.php">Projets</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="./../pages/back_msg.php">Messages</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="./../pages/logout.php">Déconnexion</a>
                                </li>
                            </ul>
                        </div>';
                    } 
                    ?>
                </div>
            </nav>
        </header>

        <main>
            <?php 

                if ($_SESSION['logged'] == 'oui') {

                    echo '<div class="container">
                        <h3 class="mt-3">Ajout d\'un projet dans la base de données</h3>
                        <!-- Formulaire d\'ajout de projet dans la bdd -->
                        <form class="form-ajout" method="post" enctype="multipart/form-data" onsubmit="return valider_projet()" action="./../pages/ajout_projet.php">
                            <div class="row mt-4 mb-3">
                                <div class="col">
                                    <label for="nom_projet" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom_projet" name="nom_projet">
                                    <div id="emailHelp" class="form-text">50 caractères maximum.</div>
                                </div>
                                <div class="col">
                                    <label for="typ_projet" class="form-label">Type de projet</label>
                                    <select id="typ_projet" class="form-select" name="typ_projet" aria-label="Default select example">
                                        <option selected>Choix</option>
                                        <option value="Formation">Formation</option>
                                        <option value="Professionnel">Professionnel</option></select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="url_projet" class="form-label">Adresse web</label>
                                    <input type="text" class="form-control" id="url_projet" name="url_projet">
                                    <div id="emailHelp" class="form-text">255 caractères maximum.</div>
                                </div>
                                <div class="col">
                                    <label for="github_projet" class="form-label">Lien GitHub</label>
                                    <input type="text" class="form-control" id="github_projet" name="github_projet">
                                    <div id="emailHelp" class="form-text">255 caractères maximum.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="desc_projet" class="form-label">Description</label>
                                    <textarea type="text" class="form-control" id="desc_projet" name="desc_projet" rows="5"></textarea>
                                    <div id="emailHelp" class="form-text">1000 caractères maximum.</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="img_projet" class="form-label">Image</label>
                                    <input class="form-control" type="file" id="img_projet" name="img_projet">
                                    <div id="emailHelp" class="form-text">Pas d\'apostrophe dans le nom - remplacer les espaces par des underscores - format jpg/jpeg/png.</div>
                                </div>
                                <div class="col">
                                    <label for="visibilite_projet" class="form-label">Projet visible sur portfolio</label>
                                    <select id="visibilite_projet" class="form-select" name="visibilite_projet" aria-label="Default select example">
                                        <option selected>Choix</option>
                                        <option value="oui">Oui</option>
                                        <option value="non">Non</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="langage_projet" class="form-label">Langages</label>
                                <div class="col">
                                    <div class="row">
                                        <div class="form-group form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="chk_html" id="chk_html" value="HTML">
                                            <label class="form-check-label" for="chk_html">HTML</label>
                                            <input class="form-check-input" type="checkbox" name="chk_css" id="chk_css" value="CSS">
                                            <label class="form-check-label" for="chk_css">CSS</label>
                                            <input class="form-check-input" type="checkbox" name="chk_boot" id="chk_boot" value="BOOTSTRAP">
                                            <label class="form-check-label" for="chk_boot">BOOTSTRAP</label>
                                            <input class="form-check-input" type="checkbox" name="chk_sass" id="chk_sass" value="SASS">
                                            <label class="form-check-label" for="chk_sass">SASS</label>
                                            <input class="form-check-input" type="checkbox" name="chk_less" id="chk_less" value="LESS">
                                            <label class="form-check-label" for="chk_less">LESS</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="chk_js" id="chk_js" value="JS">
                                            <label class="form-check-label" for="chk_js">JS</label>
                                            <input class="form-check-input" type="checkbox" name="chk_jquery" id="chk_jquery" value="JQuery">
                                            <label class="form-check-label" for="chk_jquery">JQuery</label>
                                            <input class="form-check-input" type="checkbox" name="chk_bat" id="chk_bat" value=".BAT">
                                            <label class="form-check-label" for="chk_bat">.BAT</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="chk_php" id="chk_php" value="PHP">
                                            <label class="form-check-label" for="chk_php">PHP</label>
                                            <input class="form-check-input" type="checkbox" name="chk_symfony" id="chk_symfony" value="SYMFONY">
                                            <label class="form-check-label" for="chk_symfony">SYMFONY</label>
                                            <input class="form-check-input" type="checkbox" name="chk_vue" id="chk_vue" value="VUE.JS">
                                            <label class="form-check-label" for="chk_vue">VUE.JS</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="chk_mysql" id="chk_mysql" value="MySQL">
                                            <label class="form-check-label" for="chk_mysql">MySQL</label>
                                            <input class="form-check-input" type="checkbox" name="chk_sqlite" id="chk_sqlite" value="SQLite">
                                            <label class="form-check-label" for="chk_sqlite">SQLite</label>
                                            <input class="form-check-input" type="checkbox" name="chk_maria" id="chk_maria" value="MariaDb">
                                            <label class="form-check-label" for="chk_maria">MariaDb</label>
                                            <input class="form-check-input" type="checkbox" name="chk_informix" id="chk_informix" value="Informix">
                                            <label class="form-check-label" for="chk_informix">Informix</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <textarea type="text" class="form-control" id="comp_projet" name="comp_projet" rows="3" readonly></textarea>
                                </div>
                            </div>
                            <!-- Bouton d\'ajout -->
                            <div class="row d-flex justify-content-center mt-5 mb-3">
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Trait de séparation -->
                    <div class="container">
                        <div class="divider py-1 bg-dark"></div>
                    </div>

                    <!-- liste des projets -->
                    <div class="container mb-5 table-responsive">
                        <h3 class="mt-3 mb-4">Liste des projets</h3>';

                        require $lien.'pages/conn_bdd.php';

                            try{

                                $sth = $conn->prepare("SELECT COUNT(id_proj) FROM projets WHERE visibilite_proj = 1");
                                $sth->execute();
                                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                $nb_projets_tot = $sth->fetchColumn();

                                $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
                                $limite = 10;
                                $debut = ($page - 1) * $limite;
                                $nombreDePages = ceil($nb_projets_tot / $limite);

                                $sth = $conn->prepare("SELECT * FROM projets LIMIT :limite OFFSET :debut");
                                $sth->bindValue('limite', $limite, PDO::PARAM_INT);
                                $sth->bindValue('debut', $debut, PDO::PARAM_INT); 
                                $sth->execute();
                                //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
                                $projets = $sth->fetchAll(PDO::FETCH_ASSOC);

                                $total_pages = ceil($nb_projets_tot/10);

                                echo '<table class="table table-striped" id="tableau_projets">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center text-nowrap">Id <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Nom <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Type <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Langages <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Description <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Url Web <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Url GitHub <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Img <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Visible <img class="fleches" src="'.$lien.'img/up-and-down-arrows.png" alt="flèches de tri"></th>
                                                <th scope="col" class="text-center text-nowrap">Outils</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pg-results">
                                        </tbody>
                                    </table>
                                    <div class="">
                                        <div class="pagination d-flex justify-content-center"></div>
                                    </div>';

                                /*Fermeture de la connexion à la base de données*/
                                $sth = null;
                                $conn = null;
                            }
                            catch(PDOException $e){
                                
                                date_default_timezone_set('Europe/Paris');
                                setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
                                $format1 = '%A %d %B %Y %H:%M:%S';
                                $date1 = strftime($format1);
                                $fichier = fopen('./../log/error_log_back_jeux.txt', 'c+b');
                                fseek($fichier, filesize('./../log/error_log_back_jeux.txt'));
                                fwrite($fichier, "\n\n" .$date1. " - Erreur import liste jeux. Erreur : " .$e);
                                fclose($fichier);

                                /*Fermeture de la connexion à la base de données*/
                                $sth = null;
                                $conn = null;    
                            }

            echo '</div>';
            } else {

                echo '<div class="container">
                        <h3 class="mt-5 mb-5">Merci de vous connecter à votre compte.</h3>
                    </div>';

            }
        ?>    
        </main>

        <footer class="footer mt-auto py-3 bg-dark">
            <span class="text-muted d-flex justify-content-center"><p>Aymeric Guinot <span class="rouge">© 2022</span> | <a href="mentions.html" >mentions <span class="rouge">légales</span></a></p></span>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="//rawgit.com/botmonster/jquery-bootpag/master/lib/jquery.bootpag.min.js" type="text/javascript"></script>
        <script src="./../js/back_projets.js"></script> 

        <script type="text/javascript">
            $(document).ready(function() {
                $("#pg-results").load("fetch_data.php");
                $(".pagination").bootpag({
                    total: <?php echo $total_pages; ?>,
                    page: 1,
                    maxVisible: 5,
                    wrapClass: 'pagination',
                    activeClass: 'active',
                    disabledClass: 'disabled',
                }).on("page", function(e, page_num){
                    e.preventDefault();
                    /*$("#results").prepend('<div class="loading-indication"><img src="ajax-loader.gif" /> Loading...</div>');*/
                    $("#pg-results").load("fetch_data.php", {"page": page_num});
                });
            });
        </script>
        <script src="./../js/tri_tableau.js"></script> 
    </body>
    
</html>




<div class="modal fade modal-lg" id="Modif_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modification d'un projet</h5>
      </div>
      <div class="modal-body" id="affichage_modal">
            <!-- affichage des données depuis le fetch en js -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
    </div>
    </div>
  </div>
</div>


