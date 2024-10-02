<?php

namespace App\Vue;

use App\Utilitaire\Vue_Composant;

class Vue_ModifierUtilisateur extends Vue_Composant
{

    /**
     * @param mixed $data
     */
    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    function donneTexte(): string
    {
        $str= "
        <h1>Vous modifiez un enregistrement de ma table utilisateurs !</h1>
        <div  style='    width: 50%;    display: block;    margin: auto;'> 
            <form method='post'>
                <input type='hidden' name='case' value ='utilisateur'>
                <input type='hidden' name='action' value ='enregistrerModifier'>
                <input type='hidden' name='id_utilisateur' value ='".$this->data["id_utilisateur"]."'>
                <label for='nom'>nom</label>
                <input type='text' name='nom' value='".$this->data["nom"]."'><br>
                <label for='prenom'>prenom</label>
                <input type='text' name='prenom' value='".$this->data["prenom"]."'><br>
                <label for='mdp'>mdp</label>
                <input type='text' name='mdp' value='".$this->data["mdp"]."'><br>
                <button type='submit' > Modifier</button>
            </form>
        </div>
        ";
        return $str ;
    }
}