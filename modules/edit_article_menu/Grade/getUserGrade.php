<?php
	/*
	* Created on Wed Apr 28 2021
	* Latest update on Wed May 5 2021
	* Info - PHP for grade module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	//CLASS IMPORT
	require ("../../../POO/class_saveload_strategies.php");

	$ID = $_GET['ID'];

	$saveload = new SaveLoadStrategies("../../../");
	$cols = array();
	array_push($cols, "note");
	$conditions = array();
	//Todo Get user ID with session later
	array_push($conditions, array("id_article", $ID), array("id_user", $_SESSION['userID']));
	
	$res = $saveload->loadAsDB("note", $cols, $conditions, null);
	if(empty($res)) { http_response_code(520); }
	else {
		echo json_encode($res); 
		http_response_code(200);
	}
?>