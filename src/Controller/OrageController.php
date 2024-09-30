<?php

namespace App\Controleur;

class OrageDistanceController
{
    public function calculate()
    {
        $resultat = null;
        $temps = $_POST['temps'] ?? null;

        if ($temps) {
            $resultat = $temps * 343;
        }

        include __DIR__ . '/../Vue/Vue_Orage.php';
    }
}