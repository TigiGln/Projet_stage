<?php
	/*
	* Created on Fri Apr 23 2021
	* Latest update on Tue May 4 2021
	* Info - PHP for send module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	//CLASS IMPORT
	require ("../../../POO/class_saveload_strategies.php");

	$userID = $_SESSION['connexion']; //use ids
	$newUserID = $_POST["newUser"]; //use ids
	$ID = $_POST["ID"];

	$saveload = new SaveLoadStrategies("../../../POO");
	if(!$saveload->checkAsDB("article", array("num_access"), array(array("num_access", $ID)))) { http_response_code(404); }
	else if(!$saveload->checkAsDB("user", array("id_user"), array(array("id_user", $newUserID)))) { http_response_code(404); }
	else {
		$cols = array();
		array_push($cols, array("id_user", $newUserID));
		$conditions = array();
		array_push($conditions, array("num_access", $ID));
		http_response_code($saveload->saveAsDB("article", $cols, $conditions, true));
	}
	echo http_response_code();
?>