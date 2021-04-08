<?php
try
{
	// On se connecte à MySQL
	$db = $_SERVER['dbBd'];
	$serveurname = $_SERVER['dbHost'];
	$id = $_SERVER['dbLogin'];
	$mdp = $_SERVER['dbPass'];
	$bdd = new PDO("mysql:host=$serveurname;dbname=$db", $id, $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	print "<p>Votre connexion à la base de données est réussie</p>";
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}




?>
