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
	$date = $_POST["date"];
	$tag = "annotation";

	/* Handle Annotation Removal */
	if(file_exists($file)) {
		if(isset($xml->$ID)) {
			foreach ($xml->$ID->{$tag} as $annotation) {
				$atr = $annotation->attributes();
				if($atr == $date) {
					unset($annotation[0][0]);
					break;
				}
			}
	
			$save = $xml->saveXML($file);
			($save != false) ? http_response_code(200) : http_response_code(424);
		} else { http_response_code(403); }
	} else { http_response_code(404); } 
?>