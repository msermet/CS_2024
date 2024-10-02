<?php

namespace App\Modele;

use App\Utilitaire\Singleton_ConnexionPDO;
use PDO;

class Modele_Utilisateur
{
    /**
     * @return mixed : le tableau des enregistrements dans la table "table"(something went wrong...)
     */
    static function  Utilisateur_Select()
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
select *
    from `utilisateurs`
    order by id_utilisateur');
        $reponse = $requetePreparee->execute(); //$reponse boolean sur l'état de la requête
        $tableauReponse = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
        return $tableauReponse;
    }

    public static function Utilisateurs_Insert(mixed $nom, mixed $prenom, mixed $mdp)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        insert into `utilisateurs` (nom, prenom, mdp) values (:nom, :prenom, :mdp)');
        $reponse = $requetePreparee->execute(array(
            "nom" => $nom,
            "prenom" => $prenom,
            "mdp" => $mdp
        ));
        return $reponse;
    }

    public static function Utilisateurs_Delete(mixed $id)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        delete from `utilisateurs` where id_utilisateur=:id');
        $reponse = $requetePreparee->execute(array(
            "id" => $id
        ));
        return $reponse;
    }

    public static function Utilisateurs_SelectById(mixed $id)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        select * from `utilisateurs` where id_utilisateur=:id');
        $reponse = $requetePreparee->execute(array(
            "id" => $id
        ));
        $tableauReponse = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        return $tableauReponse;
    }

    public static function Utilisateur_Update(mixed $id, mixed $nom, mixed $prenom, mixed $mdp)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        update `utilisateurs` set nom=:nom, prenom=:prenom, mdp=:mdp where id_utilisateur=:id');
        $reponse = $requetePreparee->execute(array(
            "id" => $id,
            "nom" => $nom,
            "prenom" => $prenom,
            "mdp" => $mdp
        ));
        return $reponse;
    }

}