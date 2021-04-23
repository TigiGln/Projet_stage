<?php
	session_start();
	$xml = simplexml_load_file('./comments.xml');
	$ID = "ID".$_POST["ID"];
	$text = $_POST["text"];
	$color = $_POST["color"];
	$comment = $_POST["comment"];
	$date = "d".(new DateTime())->format('Y-m-d_h-i-s');
	if(!isset($xml->$ID)) { $xml->addChild($ID, " "); }
	$xml->$ID->addChild($date, "");
	$xml->$ID->$date->addChild("author", $_SESSION['connexion']);
	$xml->$ID->$date->addChild("text", $text);
	$xml->$ID->$date->addChild("color", $color);
	$xml->$ID->$date->addChild("comment", $comment);
	//Return status code and datas
	//header("date: ".$date);
	echo $date.','.$_SESSION['connexion'];
	http_response_code(200);
	$xml->saveXML('./comments.xml'); 
?>