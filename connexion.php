<?php
try
{
	// On se connecte à la base de donnée
	$bdd = new PDO('mysql:host=localhost;port=3308;dbname=stage;charset=utf8', 'thierry', 'Th1erryG@llian0', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	print "<p>Votre connexion à la base de données est réussie</p>";
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
    die('<div class="alert alert-danger" role="alert">'.$e->getMessage() . '</div>');
}

?>