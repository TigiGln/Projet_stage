<?php
/*
 * Created on Mon Apr 19 2021
 * Latest update on Mon May 10 2021
 * Info - readArticle is the common page to use article editing tools that features html/xml code.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

//CLASS IMPORT
require('../POO/class_main_menu.php');
require('../POO/class_edit_article_menu.php'); 
require('../POO/class_article_fetcher.php');
require("../POO/class_manager_bd.php");
?>

<?php
include('../views/header.php');
//Menu
(new mainMenu('Tasks'))->write();

//Database
$user = $_SESSION['username'];
$userID = $_SESSION['userID'];
?>
<div id="display" class="flex p-4 w-100 overflow-auto" style="height: 100vh;">
<?php
/* CHECK IF THE QUERIED NUM ACCESS IS IN THE PARAMETERS */
if(isset($_GET['NUMACCESS']) && isset($_GET['ORIGIN'])) {
	$articleFecther = new ArticleFetcher($_GET['ORIGIN'], $_GET['NUMACCESS']);
	if($articleFecther->doExist() && $articleFecther->hasRights($userID)) { 
		/* contents */
		$pdfData = $articleFecther->fetchPDF();
 		if($articleFecther->fetch()) {
			/* dropdown */
			echo '<span class="btn-group">
			<button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
			Switch Display
			</button>
			<ul class="dropdown-menu">
			<li><a class="dropdown-item" onClick="switchDisplay(\'article\')">HTML</a></li>';
			if($pdfData) echo '<li><a class="dropdown-item" onClick="switchDisplay(\'pdf\')">PDF</a></li>';
			echo '</ul></span><br>';
			/* other categories - Wrote before html to avoid hierarchy issues caused by PMC html */
			if($pdfData) { echo $pdfData; }
			/* html */
			echo '<div id="article" class="switchDisplay">';
			echo ($articleFecther->getArticle())['html_xml'];
			echo "</div>";
			echo "</div>";
			echo (new editArticleMenu($articleFecther->getArticle(), array("notes", "annotate", "annotate threads", "send", "grade", "conclude")))->write();
			echo '<script src="./scripts/dragArticleMenu.js"></script>';
			echo '<script src="./scripts/upgradePMCLinks.js"></script>';
			echo '<script src="./scripts/switchContent.js"></script>';
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
include('../views/footer.php');
?>