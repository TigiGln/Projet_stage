<?php
	/*
	* Created on Mon May 3 2021
	* Latest update on Wed May 5 2021
	* Info - JS for annotate threads module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/

	session_start();
	require("../../../POO/class_saveload_strategies.php");
	/* Parse Request Parameters */
	$file = "./replies.xml";
	$ID = $_GET['ORIGIN'].'_'.$_GET['ID'];
	$user = $_SESSION['username'];
	$tag = "author";
	/* Prepare Header */
	header("Content-type: text/plain");

	/* Handle Notes Loadings */
	$load = new SaveLoadStrategies("../../../POO/");
	$res = $load->loadAsXML($file, $ID, $tag, null);
	if($res == 404) { http_response_code(404); }
	else {
		http_response_code(200);
		echo $res;
	}
?>