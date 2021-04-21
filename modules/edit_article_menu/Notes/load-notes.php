<?php
	session_start();
	$xml = simplexml_load_file('./notes.xml');
	$ID = "ID".$_POST["PMCID"];
	$AUTHOR = $_SESSION['connexion'];
	//if set, we can load
	if(isset($xml->$ID) && isset($xml->$ID->$AUTHOR)) {
		http_response_code(202);
	}
	else { http_response_code(404); }
?>