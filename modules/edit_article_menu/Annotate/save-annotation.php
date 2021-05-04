<?php
	/*
	* Created on Mon Apr 19 2021
	* Latest update on Tue May 4 2021
	* Info - PHP for annotate module in edit article menu
	* @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
	*/
	session_start();
	/* Parse Request Parameters */
	$user = $_SESSION['connexion'];
	$date = (new DateTime())->format('Y-m-d-h-i-s');
	echo $date.','.$user;
?>