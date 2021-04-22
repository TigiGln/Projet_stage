<?php
	session_start();
	header("Content-type: text/plain");
	$xml = simplexml_load_file('./notes.xml');
	//IF 1, send all notes of this article but user one
	$ALL = $_GET["ALL"];
	$ID = "ID".$_GET['ID'];
	$user = $_SESSION['connexion'];
	$NOTES = "notes";
	//if set, we can load
	if(isset($xml->$ID)) {
		//If we want all
		if($ALL == 1) {
			$value = "OTHERS";
			if(isset($xml->$ID)) {
				foreach ($xml->$ID->$NOTES as $note) {
					$data = $note->attributes();
					$data = explode(";", $data);
					if($data[0] != $user) { 
						$value = $value . "," . $note->attributes();
					}
				}
			}
			echo $value;
		} else { //get user note 
			foreach ($xml->$ID->{$NOTES} as $note) {
				foreach ($xml->$ID->$NOTES as $note) {
					$value = $note->attributes();
					$data = explode(";", $value);
					if($data[0] == $user) { 
						echo "USER,".$value;
						exit;
					}
				}
			} 
		}
	} else { echo 'not not found for ALL='.$ALL; }
	/*

	session_start();
	header("Content-type: text/plain");
	$xml = simplexml_load_file('./notes.xml');
	//IF 1, send all notes of this article but user one
	$ALL = $_GET["ALL"];
	$ID = "ID".$_GET['ID'];
	$user = $_SESSION['connexion'];
	$NOTES = "notes";
	//if set, we can load
	if(isset($xml->$ID)) {
		//If we want all
		if($ALL == 1) {
			$value = "OTHERS";
			if(isset($xml->$ID)) {
				foreach ($xml->$ID->$NOTES as $note) {
					$value = $value . "," . $note->attributes();
				}
			}
			echo $value;
		} else { //get user note
			foreach ($xml->$ID->{$NOTES} as $note) {
				if($note->author == $user) {
					echo "USER,". $note->'content';
				}
			}
		}
	}
	else { echo 'not not found for ALL='.$ALL; }
	*/
?>