<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Controller/ImcController.php';
require_once __DIR__ . '/../src/Controller/OrageController.php';

use App\Controleur\ImcController;
use App\Controleur\OrageDistanceController;

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'imc':
        $controller = new ImcController();
        $controller->calculate();
        break;
    case 'orage-distance':
        $controller = new OrageDistanceController();
        $controller->calculate();
        break;
    default:
        echo "<h1>Bienvenue</h1>";
        echo "<p><a href='?action=imc'><button>Calculer l'IMC</button></a></p>";
        echo "<p><a href='?action=orage-distance'><button>Calculer la distance d'un orage</button></a></p>";
        break;
}
?>