<?php

$Vue->setMenu(new \App\Vue\Vue_Menu_Utilisateur());
switch ($action) {
    case "defaut":
        $data = \App\Modele\Modele_Utilisateur::Utilisateur_Select();
        $Vue->addToCorps(new \App\Vue\Vue_AccueilUtilisateur($data));
        break;
    case "ajouter":
        $Vue->addToCorps(new \App\Vue\Vue_AjouterUtilisateur());
        break;
    case "enregistrerAjouter":
        $data = \App\Modele\Modele_Utilisateur::Utilisateurs_Insert($_REQUEST["nom"], $_REQUEST["prenom"], $_REQUEST["mdp"]);

        $data = \App\Modele\Modele_Utilisateur::Utilisateur_Select();
        $Vue->addToCorps(new \App\Vue\Vue_AccueilUtilisateur($data));
        break;
    case "supprimer":
        $data = \App\Modele\Modele_Utilisateur::Utilisateurs_Delete($_REQUEST["id"]);
        $data = \App\Modele\Modele_Utilisateur::Utilisateur_Select();
        $Vue->addToCorps(new \App\Vue\Vue_AccueilUtilisateur($data));
        break;
    case "modifier":
        $data = \App\Modele\Modele_Utilisateur::Utilisateurs_SelectById($_REQUEST["id"]);
        $Vue->addToCorps(new \App\Vue\Vue_ModifierUtilisateur($data));
        break;
    case "enregistrerModifier":
        \App\Modele\Modele_Utilisateur::Utilisateur_Update($_REQUEST["id_utilisateur"], $_REQUEST["nom"], $_REQUEST["prenom"], $_REQUEST["mdp"]);
        $data = \App\Modele\Modele_Utilisateur::Utilisateur_Select();
        $Vue->addToCorps(new \App\Vue\Vue_AccueilUtilisateur($data));

        break;

}