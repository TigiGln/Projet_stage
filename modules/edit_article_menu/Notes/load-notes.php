<?php
	/*
	* Created on Tue Apr 21 2020
	* Latest update on Mon Apr 26 2021
	* Info - PHP for notes module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/

	session_start();
	/* Parse Request Parameters */
	$file = "./notes.xml";
	$all = $_GET["ALL"]; //If 1, send all notes of this article but user's ones.
	$ID = "ID".$_GET['ID'];
	$user = $_SESSION['connexion'];
	$tag = "author";
	$sep = ";";
	$subSep = ',';
	/* Prepare Header */
	header("Content-type: text/plain");

	/* Handle Notes Loadings */
	if(file_exists($file)) {
		$xml = simplexml_load_file($file);
		if(isset($xml->$ID)) {
			switch ($all) {
			    case 0:
			        loadUserNotes($xml->$ID, $tag, $user, $sep);
			        http_response_code(200);
			        break;
			    case 1:
			        loadOthersNotes($xml->$ID, $tag, $user, $sep, $subSep);
			        http_response_code(200);
			        break;
			    default:
			    	http_response_code(403);
			        break;
			}
		}
	} else { http_response_code(404); }

	/**
	 * loadUserNotes is a function to load the user's notes from the notes xml database. If the user wrote nothing, echo nothing
 	 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	 * @param  mixed $articleNode
	 * @param  mixed $tag
	 * @param  mixed $user
	 * @param  mixed $sep
	 * @return void
	 */
	function loadUserNotes($articleNode, $tag, $user, $sep) {
		foreach ($articleNode->{$tag} as $note) {
			$atr = $note->attributes();
			if($atr == $user) { 
				echo "USER,".$note->content;
				exit;
			}
		} 
	}

	
	/**
	 * loadOthersNotes is a function to load the others' notes from the notes xml database.
 	 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	 * @param  mixed $articleNode
	 * @param  mixed $tag
	 * @param  mixed $user
	 * @param  mixed $sep
	 * @param  mixed $subSep
	 * @return void
	 */
	function loadOthersNotes($articleNode, $tag, $user, $sep, $subSep) {
		$res = "OTHERS";
		foreach ($articleNode->{$tag} as $note) {
			$atr = $note->attributes();
			if($atr != $user) {
				$res = $res.$subSep.$atr.$sep.$note->date.$sep.$note->content;
			}
		} 
		echo $res;
	}
?>