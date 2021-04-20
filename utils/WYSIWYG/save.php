<?php
	$xml = simplexml_load_file('./comments.xml');
	$ID = "ID".$_POST["PMCID"];
	$text = $_POST["text"];
	$color = $_POST["color"];
	$comment = $_POST["comment"];
	$date = "DATE".$_POST["date"];//(new DateTime())->format('Y-m-d-H-i-s');
	if(!isset($xml->$ID)) { $xml->addChild($ID, " "); }
	$xml->$ID->addChild($date, "");
	$xml->$ID->$date->addChild("text", $text);
	$xml->$ID->$date->addChild("author", $_SESSION['connexion']);
	$xml->$ID->$date->addChild("color", $color);
	$xml->$ID->$text->addChild("comment", $comment);
	$xml->saveXML('./comments.xml'); 
	//Return status code and datas
	//header("date: ".$date);
	http_response_code(200);
?>