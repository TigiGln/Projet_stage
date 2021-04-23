<?php
	$ID = $_POST["ID"];
	$filename = './article-'.$ID;
	$data = implode("", $_POST);
	//Remove everything before article=
	preg_replace('/.*?(\n)/', '', $data);

	$article = fopen($filename, 'w');
	file_put_contents($filename, $data);
	fclose($article);
	//Return status code
	http_response_code(200);
?>