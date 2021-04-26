<?php
	/*
	* Created on Fri Apr 23 2020
	* Latest update on Mon Apr 26 2021
	* Info - JS for conclude module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	$xml = simplexml_load_file('./notes.xml');
	$ID = "ID".$_POST["ID"];
	$user = $_SESSION['connexion'];
	$content = $_POST["notes"];
	//TODO SAVE ON SERVER SIDE
	http_response_code(200);
?>

