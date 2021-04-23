<!--
	main PHP Page
	From here check with the cookie if the user is connected.
	For now a cookie with a simple String Name will be used
	Later for security reason we will have to encrypt it, then
	store the encrypted ID to request user data such as its name
-->

<!--
	Two cases: If not connected, show the connection view (signIn)
	If connected, show the "my tasks" view (myTasks)
-->

<!-- Cookie set example:
    setcookie('username', $username);
    $_COOKIE['username'] = $username;
-->
<?php
include('./views/header.html');

//DEBUG: SET COOKIE
$username = 'John Doe';
//setcookie('connexion', $username);
//$_COOKIE['connexion'] = $username;
$_SESSION["connexion"] = $username; //Todo use item, but here its just for debug issues

//Check if the cookie exist, simple mockup for now
//To retrieve cookie data: $_COOKIE['username'];
if(isset($_SESSION["connexion"])) {
	//Will cause a redirection
	header('Location: ./test_insertion_simple/test_fenetre_indefini.php?status=to_treat');
} else {
	$connectErr = "";
	header('Location: ./signIn.php');
}
?>
