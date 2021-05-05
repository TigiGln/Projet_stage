<?php
/*
 * Created on Mon Apr 19 2021
 * Latest update on Mon Apr 26 2021
 * Info - index page
 * Two cases: If not connected, show the connection view (signIn), if connected, show the "my tasks" view (myTasks)
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */
include('./views/header.php');

if(isset($_SESSION['username']) && isset($_SESSION['userName'])) {
	header('Location: ./trie_table_statut/page_table.php?status=2');
} else {
	$connectErr = "";
	header('Location: ./connection/form_connection.php');
}
?>
