/* fichier javascript en mode strict */
"use strict"; 

function valider_projet(){

    let nom_proj = document.getElementById('nom_projet').value;
    let desc_proj = document.getElementById('desc_projet').value;
    let typ_proj = document.getElementById('typ_projet').value;
    let img_proj = document.getElementById('img_projet').value;
    let url_proj = document.getElementById('url_projet').value;
    let github_proj = document.getElementById('github_projet').value;
    let comp_proj = document.getElementById('comp_projet').value;
    let visibilite_proj = document.getElementById('visibilite_projet').value;
    let tbl_format_img = img_proj.split(".");

    if (nom_proj==""){
        alert("Merci de saisir un nom de projet");
        return false;
    } else if (url_proj==""){
        alert("Merci de saisir l'url du projet");
        return false;
    } else if (github_proj==""){
        alert("Merci de saisir le lien GitHub du projet");
        return false;
    } else if (desc_proj==""){
        alert("Merci de saisir la déscription du projet");
        return false;
    } else if (img_proj==""){
        alert("Merci de sélectionner l'image de présentation du projet");
        return false;
    } else if (typ_proj=="Choix"){
        alert("Merci de sélectionner le type de projet");
        return false;
    }else if (tbl_format_img[1]!="jpg" && tbl_format_img[1]!="jpeg" && tbl_format_img[1]!="png"){
        alert("Merci de sélectionner une image au format jpg ou png");
        return false;
    } else if (visibilite_proj=="Choix"){
        alert("Merci de sélectionner la visibilité du projet");
        return false;   
    } else if (comp_proj==""){
        alert("Merci de sélectionner les compétences utilisées dans le projet");
        return false; 
    } else {
        return true;
    }
}

function valider_projet2(){

    let nom_proj = document.getElementById('nom_projet2').value;
    let desc_proj = document.getElementById('desc_projet2').value;
    let typ_proj = document.getElementById('typ_projet2').value;
    let url_proj = document.getElementById('url_projet2').value;
    let github_proj = document.getElementById('github_projet2').value;
    let comp_proj = document.getElementById('comp_projet2').value;
    let visibilite_proj = document.getElementById('visibilite_projet2').value;
    let tbl_class_IF = document.getElementById('input_file').className;
    let id_comp= "";

    if ((tbl_class_IF.indexOf('d-none') > -1) == true){
        id_comp = "img_projet3";
    } else {
        id_comp = "img_projet2";
    }

    let img_proj = document.getElementById(id_comp).value;
    let tbl_format_img = img_proj.split(".");

    if (nom_proj==""){
        alert("Merci de saisir un nom de projet");
        return false;
    } else if (url_proj==""){
        alert("Merci de saisir l'url du projet");
        return false;
    } else if (github_proj==""){
        alert("Merci de saisir le lien GitHub du projet");
        return false;
    } else if (desc_proj==""){
        alert("Merci de saisir la déscription du projet");
        return false;
    } else if (img_proj==""){
        alert("Merci de sélectionner l'image de présentation du projet");
        return false;
    } else if (typ_proj=="Choix"){
        alert("Merci de sélectionner le type de projet");
        return false;
    }else if (tbl_format_img[1]!="jpg" && tbl_format_img[1]!="jpeg" && tbl_format_img[1]!="png"){
        alert("Merci de sélectionner une image au format jpg ou png");
        return false;
    } else if (visibilite_proj=="Choix"){
        alert("Merci de sélectionner la visibilité du projet");
        return false;   
    } else if (comp_proj==""){
        alert("Merci de sélectionner les compétences utilisées dans le projet");
        return false; 
    } else {
        return true;
    }
}


const boitesACocher = document.querySelectorAll('.form-check-input');

boitesACocher.forEach(function(boiteACocher) { 

    boiteACocher.addEventListener('change', function() {

        const textComps = document.getElementById('comp_projet');
        let valeurCheck = this.value;
        let indexValeur = textComps.value.indexOf(valeurCheck);

        if (this.checked) {

            if(indexValeur!==-1){
                // chaine déjà présente dans la liste => anormal mais on ne l'ajoute pas une seconde fois
            } else {
                // chaine non présente dans la liste, on l'ajoute:
                let nouvListeComp = textComps.value + valeurCheck + " / ";
                textComps.innerText = nouvListeComp;
            }

        } else {

            if(indexValeur!==-1){
                // chaine présente dans la liste => on la supprime de la liste
                let nouvListeCompRetrait = textComps.value.replace(valeurCheck + " / ", "");
                textComps.innerText = nouvListeCompRetrait;
            } else {
                // chaine non présente dans la liste => anormal mais on n'a donc rien à retirer.
            }
        }

    });

});


function Suppr_projet(event){

    let type_element= event.target.id;

    let id_bouton = "";

    if (type_element == ""){
        id_bouton = event.target.name;
    } else {
        id_bouton = event.target.id;
    }

    let tb_split_id = id_bouton.split("_");
    let id_projet = tb_split_id[1];
    let donnees = {"id_projet": id_projet};

    fetch_post('./suppr_projet.php', donnees).then(function(response) {

        if(response=='suppression reussie'){

            alert('Projet supprimé !');
            window.location.href = "back_projet.php";


        } else if (response=='erreur suppression projet') {

            alert('Echec de la suppression du projet - annulation');

        } else if (response=='echec connexion bdd') {

            alert('Echec de la connexion à la base de données - annulation');

        } else if (response=='test if echec') {

            alert('Echec identification du projet - annulation');

        }

    });

}


$(document).on("click", ".open_modal", function () {
    var myId = $(this).data('id');
    let donnees = {"id_projet": myId};

    fetch_post('./modal_modif_projet.php', donnees).then(function(response) {

        document.getElementById('affichage_modal').innerHTML = response;

        var myModal = new bootstrap.Modal(document.getElementById("Modif_Modal"));
        checkboxModal();
        myModal.show();

    });

});


function Modif_contenu_page(){

    let tbl_class_IF = document.getElementById('input_file').className;

    if ((tbl_class_IF.indexOf('d-none') > -1) == true){

        document.getElementById('input_file').setAttribute ("class", "d-flex row");
        document.getElementById('input_text').setAttribute ("class", "d-none row");
        document.getElementById('img_projet3').value = "";

    } else {

        document.getElementById('input_file').setAttribute ("class", "d-none row");
        document.getElementById('input_text').setAttribute ("class", "d-flex row");

    }

}


function data(data) {

    let text = "";

    for (var key in data) {
      text += key + "=" + data[key] + "&";
    }

    return text.trim("&");
}


function fetch_post(url, dataArray) {

    let dataObject = data(dataArray);

    return fetch(url, {
             method: "post",
             headers: {
                   "Content-Type": "application/x-www-form-urlencoded",
             },
             body: dataObject,
        })
        .then((response) => response.text())
        .catch((error) => console.error("Error:", error));

}


function checkboxModal(){

    const boitesACocherModal = document.querySelectorAll('.form-check-input');

    boitesACocherModal.forEach(function(boitesACocherModal) { 

        boitesACocherModal.addEventListener('change', function() {

            const textCompsModal = document.getElementById('comp_projet2');
            let valeurCheckModal = this.value;
            let indexValeurModal = textCompsModal.value.indexOf(valeurCheckModal);

            if (this.checked) {

                if(indexValeurModal!==-1){
                    // chaine déjà présente dans la liste => anormal mais on ne l'ajoute pas une seconde fois
                } else {
                    // chaine non présente dans la liste, on l'ajoute:
                    let nouvListeCompModal = textCompsModal.value + valeurCheckModal + " / ";
                    textCompsModal.innerText = nouvListeCompModal;
                }

            } else {

                if(indexValeurModal!==-1){
                    // chaine présente dans la liste => on la supprime de la liste
                    let nouvListeCompRetraitModal = textCompsModal.value.replace(valeurCheckModal + " / ", "");
                    textCompsModal.innerText = nouvListeCompRetraitModal;
                } else {
                    // chaine non présente dans la liste => anormal mais on n'a donc rien à retirer.
                }
            }

        });

    });

}
