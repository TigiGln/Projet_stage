<?php
	/*
	* Created on Mon Apr 19 2021
	* Latest update on Mon May 3 2021
	* Info - PHP for annotate module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	//CLASS IMPORT
	require ("../../../POO/class_saveload_strategies.php");

	$userID = $_SESSION['connexion']; //use ids
	/* Parse Request Parameters */
	$XML = $_POST["ARTICLE"];
	$ID = $_POST["ID"];


	$saveload = new SaveLoadStrategies("../../../POO");
	if(!$saveload->checkAsDB("article", array("num_access"), array(array("num_access", $ID)))) { http_response_code(404); }
	else {
		$cols = array();
		array_push($cols, array("html_xml", trim($XML)));
		$conditions = array();
		array_push($conditions, array("num_access", $ID));
		http_response_code($saveload->saveAsDB("article", $cols, $conditions, true));
	}
	echo http_response_code();	

?>