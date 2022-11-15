<?php

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    echo'  <header>
                <div class="conteneur-header">
                    <div class="conteneur-logo">
                        <a href="'.$lien.'index.php">
                            <div class="logo">
                                <p class="rouge text-flicker-in-glow">A</p>
                                <p class="blanc">G</p>
                            </div>
                        </a>
                    </div>
                    <div class="conteneur-nav">
                        <div class="nav-bar">
                            <a href="#accueil" class="accueil">Accueil</a>
                            <a href="#a_propos" class="a_propos">A propos</a>
                            <a href="#competences" class="competence">Compétences</a>
                            <a href="#portfolio" class="folio">Portfolio</a>
                            <a href="#contact" class="contact">Contact</a>
                            <a href="'.$lien.'files/CV-GUINOT_Aymeric-dev_web_fullstack.pdf" download="CV-GUINOT_Aymeric-dev_web_fullstack">C.V.</a>
                        </div>
                        <div class="burger">
                            <div id="menuToggle">
                                <input type="checkbox" />
                                <span></span>
                                <span></span>
                                <span></span>
                                <ul id="menu">
                                    <a href="#accueil" class="accueil"><li>Accueil</li></a>
                                    <a href="#a_propos" class="a_propos"><li>A propos</li></a>
                                    <a href="#competences" class="competence"><li>Compétences</li></a>
                                    <a href="#portfolio" class="folio"><li>Portfolio</li></a>
                                    <a href="#contact" class="contact"><li>Contact</li></a>
                                    <a href="./files/CV.pdf" download="newfilename"><li>C.V.</li></a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        ';
?>