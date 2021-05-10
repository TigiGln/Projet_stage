<?php
	/*
	* Created on Fri Apr 23 2021
	* Latest update on Wed May 5 2021
	* Info - PHP for conclude module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	//CLASS IMPORT
	require ("../../../POO/class_saveload_strategies.php");

	$userID = $_SESSION['userID'];
	$ID = $_POST["ID"];
	$ORIGIN = $_POST["ORIGIN"];
	$status = $_POST["status"];

	$saveload = new SaveLoadStrategies("../../../");
	if(!$saveload->checkAsDB("article", array("num_access"), array(array("origin", $ORIGIN), array("num_access", $ID), array("user", $userID)))) { http_response_code(404); }
	else {
		$cols = array();
		array_push($cols, array("status", $status));
		$conditions = array();
		array_push($conditions, array("num_access", $ID), array("origin", $ORIGIN));
		http_response_code($saveload->saveAsDB("article", $cols, $conditions, true));
	}
	echo http_response_code();	
?>