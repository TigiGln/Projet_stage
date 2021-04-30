<?php
/*
 * Created on Mon Apr 19 2021
 * Latest update on Fri Apr 30 2021
 * Info - readArticle is the common page to use article editing tools that features html/xml code.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

//CLASS IMPORT
require('./POO/class_main_menu.php');
require('./POO/class_edit_article_menu.php');
require('./POO/class_article_fetcher.php');
?>

<?php
include('./views/header.php');
//Menu
(new mainMenu('My_Tasks'))->write();

//Database
$user = $_SESSION['connexion'];
$userID = 2; //$userID = $_SESSION['id'];

$connexionbd = new ConnexionDB("localhost", "stage", "root", "");
$_SESSION["connexionbd"] = $connexionbd;
$manager = new Manager($_SESSION["connexionbd"]->pdo);
?>

<div id="article" class="p-4 w-100 overflow-auto" style="height: 100vh;">

<?php
/* CHECK IF THE QUERIED NUM ACCESS IS IN THE PARAMETERS */
if(isset($_GET['NUMACCESS'])) {
	$ID = $_GET['NUMACCESS'];
	$articleFecther = new ArticleFetcher($ID);
	if($articleFecther->doExist() && $articleFecther->hasRights($userID)) { 
 		if($articleFecther->fetch()) {
			echo "</div>";
			echo (new editArticleMenu($ID))->write();
			http_response_code(200); 
		}
	}

} 
/* IF WE DON'T GAVE THE CORRECT PARAMETER */
else {
	echo '<div class="alert alert-danger" role="alert">
			This page need an argument: ?NUMACCESS=NUM
		</div>';
}
include('./views/footer.html');
?>