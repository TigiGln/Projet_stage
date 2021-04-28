<?php
	/*
	* Created on Mon Apr 19 2021
	* Latest update on Mon Apr 26 2021
	* Info - PHP for annotate module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	/* Parse Request Parameters */
	$file = "./annotations.xml";
	$xml = simplexml_load_file($file);
	$ID = "ID".$_POST["ID"];
	$user = $_SESSION['connexion'];
	$text = $_POST["text"];
	$color = $_POST["color"];
	$content = $_POST["comment"];
	$date = (new DateTime())->format('Y-m-d_h-i-s');
	$tag = "annotation";

	/* Handle Annotation Saving */
	if(file_exists($file)) {
		if(!isset($xml->$ID)) { $xml->addChild($ID, " "); }
		$annotationNode = $xml->$ID->addChild($tag,'');
		$annotationNode->addAttribute("date", $date);
		$annotationNode->addChild("author", $user);
		$annotationNode->addChild("text", $text);
		$annotationNode->addChild("color", $color);
		$annotationNode->addChild("content", rawurlencode($content));

		echo $date.','.$user;
		$save = $xml->saveXML($file);
		($save != false) ? http_response_code(200) : http_response_code(424);
	} else { http_response_code(404); } 
?>