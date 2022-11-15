<?php

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    echo'   <footer>
                <div class="pied"><p>Aymeric Guinot <span class="rouge">© 2022</span> | <a href="'.$lien.'pages/mentions.php" >mentions <span class="rouge">légales</span></a></p></div>
            </footer>
        ';
?>