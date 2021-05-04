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
	$ID = $_POST['ID'];
	$GRADE = $_POST['GRADE'];

	$saveload = new SaveLoadStrategies("../../../POO");
	$cols = array();
	array_push($cols, "*");
	$conditions = array();
	array_push($conditions, array("id_article", $ID), array("id_user", $_SESSION['userID']));
	$doExist = $saveload->checkAsDB("notes", $cols, $conditions);
	if($doExist) {
		$cols = array();
		array_push($cols, array("notes", $GRADE));
		http_response_code($saveload->saveAsDB("notes", $cols, $conditions, true));
	} else {
		$cols = array();
		array_push($cols, array("id_article", $ID), array("id_user", $_SESSION['userID']), array("notes", $GRADE));
		$conditions = array();
		http_response_code($saveload->saveAsDB("notes", $cols, $conditions, false));
	}
	echo http_response_code();	
?>