<?php
	session_start();
	$xml = simplexml_load_file('./notes.xml');
	$ID = "ID".$_POST["PMCID"];
	$content = $_POST["notes"];
	$date = "d".(new DateTime())->format('Y-m-d');
	$user = $_SESSION['connexion'];
	$NOTES = "notes";
	if(!isset($xml->$ID)) { $xml->addChild($ID, " "); }
	//check if user do already had a note //TODO XML I HATE YOU
	$xml->$ID->addChild($NOTES . " " .'note="'.$user.';'.$date.';'.rawurlencode($content).'"');
	$xml->saveXML('./notes.xml');
	http_response_code(200);

	/*
		//Check if user already have a note
	foreach ($xml->$ID->{$NOTES} as $note) {
		$xml->$ID->$NOTES->addChild("try",$AUTHOR);
		if($note->{'author'} == $user) { 
			$xml->$ID->$NOTES->addChild("exist",$AUTHOR);
			break;
		}
	}
	*/
?>

