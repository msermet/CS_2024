<?php
include_once "vendor/autoload.php";

use App\Utilitaire\Vue;
use App\Vue\Vue_BienvenueAllerPagePrecedente;
use App\Vue\Vue_BienvenueAllerPageSuivante;

if (isset($_REQUEST["case"]))
    $case = $_REQUEST["case"];
else
    $case = "defaut";

if (isset($_REQUEST["action"]))
    $action = $_REQUEST["action"];
else
    $action = "defaut";

$Vue = new Vue();
switch ($case) {
    case "A":
    case "defaut":
        include ".\src\Controleur\caseA.php";
        break;
    case "B":
        include ".\src\Controleur\caseB.php";
        break;
    case "maTable":
        include ".\src\Controleur\caseMaTable.php";
        break;
    case "utilisateur":
        include ".\src\Controleur\caseUtilisateur.php";
        break;

}
$Vue->afficher();