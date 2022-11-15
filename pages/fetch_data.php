<?php

    session_start();

    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

    if ($curPageName == "index.php") {
        $lien = "./";
    } else {
        $lien = "./../";
    }

    if (isset($_POST["page"])) {
        $page_no = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
        if(!is_numeric($page_no))
            die("Error fetching data! Invalid page number!!!");
    } else {
        $page_no = 1;
    }

    require $lien.'pages/conn_bdd.php';

    $row_limit = 10;

    // get record starting position
    $start = (($page_no-1) * $row_limit);

    $results = $conn->prepare("SELECT * FROM projets ORDER BY id_proj LIMIT $start, $row_limit");
    $results->execute();

    while($row = $results->fetch(PDO::FETCH_ASSOC)) {

        echo '<tr>
            <th scope="row" class="align-middle text-center">'.$row['id_proj'].'</th>
            <td class="align-middle text-center">'.$row['nom_proj'].'</td>
            <td class="align-middle text-center">'.$row['typ_proj'].'</td>
            <td class="align-middle text-center">'.$row['langage_proj'].'</td>
            <td class="align-middle text-center">'.$row['desc_proj'].'</td>
            <td class="align-middle text-center">'.$row['url_proj'].'</td>
            <td class="align-middle text-center">'.$row['url_github_proj'].'</td>
            <td class="align-middle text-center">'.$row['img_proj'].'</td>
            <td class="align-middle text-center">'.$row['visibilite_proj'].'</td>
            <td class="align-middle text-center">
                <div class="d-flex flex-row">
                    <div>
                        <button type="button" class="btn open_modal" data-id="'.$row['id_proj'].'" name="mod_'.$row['id_proj'].'">
                            <i name="mod_'.$row['id_proj'].'" class="fas fa-pen" data-id="'.$row['id_proj'].'" id="mod_'.$row['id_proj'].'"></i>
                        </button>
                    </div>
                    <div >
                        <button type="button" class="btn" onclick="Suppr_projet(event)" name="del_'.$row['id_proj'].'">
                            <i name="del_'.$row['id_proj'].'" class="fas fa-trash-can" id="del_'.$row['id_proj'].'"></i>
                        </button>
                    </div>
                </div>
            </td>
        </tr>';
    }

?>