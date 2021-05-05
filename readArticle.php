<?php
/*
 * Created on Mon Apr 19 2021
 * Latest update on Wed May 5 2021
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
$user = $_SESSION['username'];
$userID = $_SESSION['userID'];
?>

<div id="article" class="flex p-4 w-100 overflow-auto" style="height: 100vh;">

<?php
/* CHECK IF THE QUERIED NUM ACCESS IS IN THE PARAMETERS */
if(isset($_GET['NUMACCESS']) && isset($_GET['ORIGIN'])) {
	$ORIGIN = $_GET['ORIGIN'];
	$ID = $_GET['NUMACCESS'];
	$articleFecther = new ArticleFetcher($ORIGIN, $ID);
	if($articleFecther->doExist() && $articleFecther->hasRights($userID)) { 
 		if($articleFecther->fetch()) {
			echo "</div>";
			echo (new editArticleMenu($articleFecther->getArticle()['id_article'], $ORIGIN, $ID))->write();
			echo '<script src="./scripts/dragArticleMenu.js"></script>';
			http_response_code(200); 
		}
	}

} 
/* IF WE DON'T GAVE THE CORRECT PARAMETER */
else {
	echo '<div class="alert alert-danger" role="alert">
			This page need two arguments: ?NUMACCESS=NUM&ORIGIN=origin
		</div>';
}
include('./views/footer.html');
?>