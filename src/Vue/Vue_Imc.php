<!DOCTYPE html>
<html>
<head>
    <title>Calcul de l'IMC</title>
</head>
<body>
<h1>Calcul de l'IMC</h1>
<form method="POST" action="">
    <label for="poids">Poids (kg):</label>
    <input type="number" id="poids" name="poids" step="0.1" required>
    <br>
    <label for="taille">Taille (m):</label>
    <input type="number" id="taille" name="taille" step="0.01" required>
    <br>
    <button type="submit">Calculer</button>
</form>

<?php
if (isset($resultat)) {
    echo "<h2>Votre IMC est : " . $resultat . "</h2>";
}
?>
</body>
</html>