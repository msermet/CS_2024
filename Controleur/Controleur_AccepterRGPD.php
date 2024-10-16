<?php

use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_ConsentementRGPD;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;

$Vue->setEntete(new Vue_Structure_Entete());


switch ($action) {
    case "" :
        break;
    case "AfficherRGPD" :
        $Vue->addToCorps(new Vue_ConsentementRGPD());
        break;
    case "AccepterRGPD" :
        Modele_Utilisateur::Utilisateur_Modifier_RGPD($_REQUEST["idUtilisateur"],1);
        $Vue->addToCorps(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
        break;
    case "RefuserRGPD":
        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
        break;
    default :

}

$Vue->setBasDePage(new  Vue_Structure_BasDePage());
