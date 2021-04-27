<?php
	/*
	* Created on Fri Apr 23 2021
	* Latest update on Tue Apr 27 2021
	* Info - PHP for conclude module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	//CLASS IMPORT
	require ($_SERVER["DOCUMENT_ROOT"]."/POO/class_connexion.php");
    require ($_SERVER["DOCUMENT_ROOT"]."/POO/class_manager_bd.php");

	$user = $_SESSION['connexion'];
	$ID = $_POST["ID"];

	$manager = new Manager($_SESSION["connexionbd"]->pdo);
	if(!$manager->get_exist("article" , "id_article", $ID)) { http_response_code(404); }
	$res = $manager->updateArticleStatus($ID, '4');

	($res) ? http_response_code(200) : http_response_code(520);
		
?>

