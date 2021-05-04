<?php
	/*
	* Created on Wed Apr 28 2021
	* Latest update on Tue May 4 2021
	* Info - PHP for grade module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	//CLASS IMPORT
	require ("../../../POO/class_saveload_strategies.php");

	$user = $_SESSION['connexion'];
	$ID = $_GET['ID'];

	$saveload = new SaveLoadStrategies("../../../POO");
	$cols = array();
	array_push($cols, "notes");
	$conditions = array();
	//Todo Get user ID with session later
	array_push($conditions, array("id_article", $ID), array("id_user", 1));
	
	$res = $saveload->loadAsDB("notes", $cols, $conditions, null);
	if(empty($res)) { http_response_code(520); }
	else {
		echo json_encode($res); 
		http_response_code(200);
	}
?>