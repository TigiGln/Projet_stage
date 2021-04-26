<?php
	/*
	* Created on Mon Apr 19 2020
	* Latest update on Mon Apr 26 2021
	* Info - PHP for annotate module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/

	session_start();
	/* Parse Request Parameters */
	$ID = $_POST["ID"];
	$filename = './article-'.$ID;
	/* Handle Article Saving */
	$data = implode("", $_POST);
	preg_replace('/.*?(\n)/', '', $data);
	$article = fopen($filename, 'w');
	file_put_contents($filename, $data);
	fclose($article);

	http_response_code(200);
?>