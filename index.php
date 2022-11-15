<?php
    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    require $lien.'pages/conn_bdd.php';
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Portfolio Aymeric Guinot Développeur Web et Web Mobile Fullstack">
        <title>Portfolio d'Aymeric Guinot - développeur web full-stack</title>
        <link rel="canonical" href="https://www.portfolio.aymeric-guinot-dev.com/index.php">
        <?php
            echo'
                <link rel="stylesheet" href="'.$lien.'css/styles.css">
                <link rel="stylesheet" href="'.$lien.'css/animations.css">
                <link rel="stylesheet" href="'.$lien.'css/responsive.css">
                <link rel="shortcut icon" type="image/ico" href="'.$lien.'img/icon.png">
                ';
            ?>
    </head>

    <body>
        <?php
            /* importation header */
            include './pages/header.php';
        ?>










        <?php
            /* importation footer */
            include './pages/footer.php';
        ?>
        <script src='./js/main.js'></script>
    </body>
</html>