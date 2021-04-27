<?php
	/*
	* Created on Tue Apr 27 2021
	* Latest update on Tue Apr 27 2021
	* Info - PHP for send module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	//CLASS IMPORT
	require ($_SERVER["DOCUMENT_ROOT"]."/Projet_stage/POO/class_connexion.php");
    require ($_SERVER["DOCUMENT_ROOT"]."/Projet_stage/POO/class_manager_bd.php");

    $connexionbd = new ConnexionDB("localhost", "stage", "root", "");
    $_SESSION["connexionbd"] = $connexionbd;
	$manager = new Manager($_SESSION["connexionbd"]->pdo);
	$res = $manager->getUsers();
	echo json_encode($res); 

	http_response_code(200);	
?>