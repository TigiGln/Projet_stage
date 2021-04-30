<?php
	/*
	* Created on Mon Apr 19 2021
	* Latest update on Fri Apr 30 2021
	* Info - PHP for annotate module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	//CLASS IMPORT
	require ("../../../POO/class_connexion.php");
	require ("../../../POO/class_manager_bd.php");

	$userID = $_SESSION['connexion']; //use ids
	/* Parse Request Parameters */
	$XML = $_POST["ARTICLE"];
	$ID = $_POST["ID"];

	$connexionbd = new ConnexionDB("localhost", "stage", "root", "");
    $_SESSION["connexionbd"] = $connexionbd;
	$manager = new Manager($_SESSION["connexionbd"]->pdo);
	if(!$manager->get_exist("num_access", $ID, "article")) { http_response_code(404); }
	else {
		$cols = array();
		array_push($cols, array("html_xml", $XML));
	
		$conditions = array();
		array_push($conditions, array("num_access", $ID));

		$res = $manager->updateSpecific($cols, $conditions, "article");
		($res) ? http_response_code(200) : http_response_code(520);
	}
?>