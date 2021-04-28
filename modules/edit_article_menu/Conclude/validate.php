<?php
	/*
	* Created on Fri Apr 23 2021
	* Latest update on Wed Apr 28 2021
	* Info - PHP for conclude module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	//CLASS IMPORT
	require ("../../../POO/class_connexion.php");
    require ("../../../POO/class_manager_bd.php");

	$user = $_SESSION['connexion'];
	$ID = $_POST["ID"];

	$manager = new Manager($_SESSION["connexionbd"]->pdo);
	if(!$manager->get_exist("id_article", $ID "article")) { http_response_code(404); }
	$res = $manager->update($ID, 'status', '4', 'articles');

	($res) ? http_response_code(200) : http_response_code(520);
		
?>