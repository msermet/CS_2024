<!DOCTYPE html>
<html>
<head>
    <title>Calcul de la distance d'un orage</title>
</head>
<body>
<h1>Calcul de la distance d'un orage</h1>
<form method="POST" action="">
    <label for="temps">Temps (secondes):</label>
    <input type="number" id="temps" name="temps" step="0.1" required>
    <br>
    <button type="submit">Calculer</button>
</form>

<?php
if (isset($resultat)) {
    echo "<h2>L'orage est à " . $resultat . " mètres.</h2>";
}
?>
</body>
</html>