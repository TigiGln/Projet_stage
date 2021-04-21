<?php
	session_start();
	$xml = simplexml_load_file('./notes.xml');
	$ID = "ID".$_POST["PMCID"];
	$text = $_POST["notes"];
	$date = "DATE".$_POST["date"];//(new DateTime())->format('Y-m-d-H-i-s');
	if(!isset($xml->$ID)) { $xml->$ID->addChild($ID, " "); }
	$xml->$ID->addChild($date, "");
	$xml->$ID->addChild("author", $_SESSION['connexion']);
	$xml->$ID->addChild("notes", $text);
	$xml->saveXML('./notes.xml'); 
	//Return status code and datas
	//header("date: ".$date);
	http_response_code(200);
?>