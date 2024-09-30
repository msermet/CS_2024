<?php

namespace App\Controleur;

class ImcController
{
    public function calculate()
    {
        $resultat = null;
        $poids = $_POST['poids'] ?? null;
        $taille = $_POST['taille'] ?? null;

        if ($poids && $taille) {
            $resultat = $poids / ($taille * $taille);
        }

        include __DIR__ . '/../Vue/vue_imc.php';
    }
}