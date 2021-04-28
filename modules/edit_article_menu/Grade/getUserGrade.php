<?php
	/*
	* Created on Wed Apr 28 2021
	* Latest update on Wed Apr 28 2021
	* Info - PHP for grade module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	//CLASS IMPORT
	require ("../../../POO/class_connexion.php");
    require ("../../../POO/class_manager_bd.php");

	$user = $_SESSION['connexion'];
	$ID = $_GET['ID'];

    $connexionbd = new ConnexionDB("localhost", "stage", "root", "");
    $_SESSION["connexionbd"] = $connexionbd;
	$manager = new Manager($_SESSION["connexionbd"]->pdo);

	$cols = array();
	array_push($cols, "notes");
	$conditions = array();
	//Todo Get user ID with session later
	array_push($conditions, array("id_article", $ID), array("id_user", 1));


	$res = $manager->getSpecific($cols, $conditions, "notes");
	echo json_encode($res); 
	
	http_response_code(200);	
?>