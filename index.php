<?php
/*
 * Created on Mon Apr 19 2021
 * Latest update on Mon Apr 26 2021
 * Info - index page
 * Two cases: If not connected, show the connection view (signIn), if connected, show the "my tasks" view (myTasks)
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */
include('./views/header.html');

//DEBUG: SET SESSION AND COOKIES (to remove after we get the database)
$username = 'John Doe';
//setcookie('connexion', $username);
//$_COOKIE['connexion'] = $username;
$_SESSION["connexion"] = $username; //Todo use item, but here its just for debug issues

if(isset($_SESSION["connexion"])) {
	header('Location: /trie_table_statut/page_table.php?status=to_treat');
} else {
	$connectErr = "";
	header('Location: /signIn.php');
}
?>
