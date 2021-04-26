<?php
	session_start();
	$ID = "ID".$_POST["ID"];
	$user = $_SESSION['connexion'];
	$newUser = $_POST["newUser"];
	//TODO SAVE ON SERVER SIDE
	http_response_code(200);
?>

