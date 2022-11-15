"use strict";

function valider_form_login(){

    let identifiant = document.getElementById('login').value
    let mdp = document.getElementById('password').value

    if (!empty(identifiant)){
        alert("Merci de saisir votre identifiant.");
        return false;
    }

    if (!empty(mdp)){
        alert("Merci de saisir votre mot de passe.");
        return false;
    }

    return true;

}