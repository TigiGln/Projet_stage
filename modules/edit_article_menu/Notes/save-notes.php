<?php
	/*
	* Created on Tue Apr 21 2021
	* Latest update on Mon Apr 26 2021
	* Info - PHP for notes module in edit article menu
	* Info - SAVE NOTES AS FOLLOWING: <IDXXX> -> <author "name"> -> date, content
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/

	session_start();
	/* Parse Request Parameters */
	$file = "./notes.xml";
	$ID = "ID".$_POST["ID"];
	$content = $_POST["notes"];
	$date = (new DateTime())->format('Y-m-d');
	$user = $_SESSION['connexion'];
	$tag = "author";
	
	/* Handle Notes Saving */
	if(file_exists($file)) {
		$xml = simplexml_load_file($file);
		if(!isset($xml->$ID)) { $xml->addChild($ID, " "); }
		//Check if node exist, if yes update the node
		$didExist = false;
		foreach ($xml->$ID->{$tag} as $note) {
			$atr = $note->attributes();
			if($atr == $user) {
				$didExist = true;
				$note->date = $date;
				$note->content = $content;
			}
		}
		//If no, create a node
		if(!$didExist) {
			$userNode = $xml->$ID->addChild($tag,'');
			$userNode->addAttribute("name", $user);
			$userNode->addChild("date", $date);
			$userNode->addChild("content", rawurlencode($content));
		} 
		
		$save = $xml->saveXML($file);
		($save != false) ? http_response_code(200) : http_response_code(424);
	} else { http_response_code(404); }
?>

