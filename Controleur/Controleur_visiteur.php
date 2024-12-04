<?php


use App\Modele\Modele_Entreprise;
use App\Modele\Modele_Jeton;
use App\Modele\Modele_Salarie;
use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Mail_Confirme;
use App\Vue\Vue_Mail_ReinitMdp;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;

use App\Vue\Vue_Utilisateur_Changement_MDP;
use PHPMailer\PHPMailer\PHPMailer;
//Ce contrôleur gère le formulaire de connexion pour les visiteurs

$Vue->setEntete(new Vue_Structure_Entete());


switch ($action) {
    case "reinitmdptoken":
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = '127.0.0.1';
        $mail->Port = 1025; // Port for non-encrypted sending
        $mail->SMTPAuth = false; // No authentication required
        $mail->SMTPAutoTLS = false; // No TLS required
        $mail->setFrom('admin@cafe.fr', 'admin');

        // Retrieve email from request and find user
        $email = $_REQUEST['email-token'];
        $utilisateur = Modele_Utilisateur::Utilisateur_Select_ParLogin($email);

        if ($utilisateur) {
            // Generate token
            $valeurToken = Modele_Jeton::Insert($utilisateur['idUtilisateur']);

            // Set email recipient and body
            $mail->addAddress($email);
            $mail->Subject = 'Objet : Demande de réinitialisation de mot de passe';
            $mail->isHTML(true);
            $mail->Body = "Veuillez cliquer sur ce lien pour réinitialiser votre mot de passe : <a href='http://localhost:8000/index.php?action=token&token=$valeurToken'>Lien à cliquer</a>";

            // Send email
            if ($mail->send()) {
                $Vue->addToCorps(new Vue_Mail_Confirme());
            } else {
                $Vue->addToCorps(new Vue_Connexion_Formulaire_client("Échec de l'envoi de l'e-mail."));
            }
        } else {
            $Vue->addToCorps(new Vue_Connexion_Formulaire_client("Utilisateur introuvable."));
        }
        break;

    case "reinitmdpconfirm":
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = '127.0.0.1';
        $mail->Port = 1025; //Port non crypté
        $mail->SMTPAuth = false; //Pas d’authentification
        $mail->SMTPAutoTLS = false; //Pas de certificat TLS
        $mail->setFrom('admin@cafe.fr', 'admin');
        $utilisateur = Modele_Utilisateur::Utilisateur_Select_ParLogin($_REQUEST["email"]);
        $mail->addAddress($utilisateur["login"]);
        $mail->Subject = 'Objet : Demande de reinitialisation de mot de passe';
        $mail->isHTML(false);
        $_SESSION["motdepasseProv"] = \App\Fonctions\passgen1(10);
        $mail->Body = "Mot de passe provisoire : ".$_SESSION["motdepasseProv"];
        $mail->send();

        $Vue->addToCorps(new Vue_Mail_Confirme());
        Modele_Utilisateur::Utilisateur_Modifier_motDePasse($utilisateur['idUtilisateur'],$_SESSION["motdepasseProv"]);

        break;
    case "reinitmdp":


        $Vue->addToCorps(new Vue_Mail_ReinitMdp());

        break;


    case "Se connecter" :
        if (isset($_REQUEST["compte"]) and isset($_REQUEST["password"])) {
            //Si tous les paramètres du formulaire sont bons

            $utilisateur = Modele_Utilisateur::Utilisateur_Select_ParLogin($_REQUEST["compte"]);

            if ($utilisateur != null) {
                //error_log("utilisateur : " . $utilisateur["idUtilisateur"]);
                if ($utilisateur["desactiver"] == 0) {
                    if ($_REQUEST["password"] == $utilisateur["motDePasse"] ||$_SESSION["motdepasseProv"]==$utilisateur["motDePasse"]) {
                        $_SESSION["idUtilisateur"] = $utilisateur["idUtilisateur"];
                        //error_log("idUtilisateur : " . $_SESSION["idUtilisateur"]);
                        $_SESSION["idCategorie_utilisateur"] = $utilisateur["idCategorie_utilisateur"];
                        // echo "idCategorie_utilisateur : " . $_SESSION["idCategorie_utilisateur"];
                        //error_log("idCategorie_utilisateur : " . $_SESSION["idCategorie_utilisateur"]);
                        //  var_dump($utilisateur);


                        //ici
                        if (Modele_Utilisateur::Utilisateur_Select_RGPD($_SESSION["idUtilisateur"]) == 0) {
                            include "./Controleur/Controleur_AccepterRGPD.php";
                            //                            $msgError = "RGPD non accepté";
                            //                            $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
                            //                            $erreur = true;
                        } else
                            if (isset($_SESSION["motdepasseProv"])) {
                                include "./Controleur/Controleur_Gerer_monCompte.php";
                            }

                            switch ($utilisateur["idCategorie_utilisateur"]) {
                                case 1:
                                    $_SESSION["typeConnexionBack"] = "administrateurLogiciel"; //Champ inutile, mais bien pour voir ce qu'il se passe avec des étudiants !
                                    $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                                    break;
                                case 2:
                                    $_SESSION["typeConnexionBack"] = "gestionnaireCatalogue";
                                    $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                                    $Vue->addToCorps(new \App\Vue\Vue_AfficherMessage("Bienvenue " . $_REQUEST["compte"]));
                                    break;
                                case 3:
                                    $_SESSION["typeConnexionBack"] = "entrepriseCliente";
                                    //error_log("idUtilisateur : " . $_SESSION["idUtilisateur"]);
                                    $_SESSION["idEntreprise"] = Modele_Entreprise::Entreprise_Select_Par_IdUtilisateur($_SESSION["idUtilisateur"])["idEntreprise"];
                                    include "./Controleur/Controleur_Gerer_Entreprise.php";
                                    break;
                                case 4:
                                    $_SESSION["typeConnexionBack"] = "salarieEntrepriseCliente";
                                    $_SESSION["idSalarie"] = $utilisateur["idUtilisateur"];
                                    $_SESSION["idEntreprise"] = Modele_Salarie::Salarie_Select_byId($_SESSION["idUtilisateur"])["idEntreprise"];
                                    include "./Controleur/Controleur_Catalogue_client.php";
                                    break;
                                case 5:
                                    $_SESSION["typeConnexionBack"] = "commercialCafe";
                                    $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                                    break;
                            }
                    } else {//mot de passe pas bon
                        $msgError = "Mot de passe erroné";

                        $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));

                    }

                } else {
                    $msgError = "Compte désactivé";

                    $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));

                }
            } else {
                $msgError = "Identification invalide";

                $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
            }
        } else {
            $msgError = "Identification incomplete";

            $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
        }
    break;
    default:

        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());

        break;
}


$Vue->setBasDePage(new Vue_Structure_BasDePage());