<?php
	session_start();
	$xml = simplexml_load_file('./notes.xml');
	$ID = "ID".$_POST["ID"];
	$user = $_SESSION['connexion'];
	$content = $_POST["notes"];
	//TODO SAVE ON SERVER SIDE
	http_response_code(200);
?>

