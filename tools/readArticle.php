<?php
/*
 * Created on Mon Apr 19 2021
 * Latest update on Tue May 11 2021
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
?>

<div id="display" class="flex p-4 w-100 overflow-auto" style="height: 100vh;">

<?php
if(isset($_GET['NUMACCESS']) && isset($_GET['ORIGIN'])) {
	$articleFecther = new ArticleFetcher($_GET['ORIGIN'], $_GET['NUMACCESS']);
	if($articleFecther->doExist() && $articleFecther->hasRights($_SESSION['userID'])) { 

		/* contents building */
		$hidden = "";
		$htmlData = $articleFecther->fetchHTML($hidden); if($htmlData && empty($hidden)) { $hidden = "hidden"; }
		$pdfData = $articleFecther->fetchPDF($hidden); if($pdfData && empty($hidden)) { $hidden = "hidden"; }
		$xmlData = $articleFecther->fetchXML($hidden); if($xmlData && empty($hidden)) { $hidden = "hidden"; }
		$datas = array(
			array("html", $htmlData),
			array("pdf", $pdfData),
			array("xml", $xmlData)
		); 
		/* contents building end */
 		if($articleFecther->fetch()) {
			showDisplays($datas);
			echo '</ul></span><br>';
			//We reverse the array because we must have html content in the end to avoid hierarchy div issues
			printDisplays(array_reverse($datas));
			echo "</div>";

			echo (new editArticleMenu($articleFecther->getArticle(), array("notes", "annotate", "annotate threads", "send", "grade", "conclude")))->write();

			echo '<script src="./scripts/dragArticleMenu.js"></script>';
			echo '<script src="./scripts/upgradePMCLinks.js"></script>';
			echo '<script src="./scripts/switchContent.js"></script>';
			http_response_code(200); 
		}
	}

} 
else {
	echo '<div class="alert alert-danger" role="alert">
			This page need two arguments: ?NUMACCESS=NUM&ORIGIN=origin
		</div>';
}
include('../views/footer.php');

/**
 * showDisplays will show and build a dropdown menu allowing to change section. 
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param  mixed $datas
 *            an array of array with two element: a string for the tag, the fetched corresponding content fetched earlier.
 * @return void
 */
function showDisplays($datas) {
	echo '<span class="btn-group">
	<button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
	Switch Display
	</button>
	<ul class="dropdown-menu">';
	foreach ($datas as $data) {
		if($data[1]) {
			echo '<li><a class="dropdown-item" onClick="switchDisplay(\''.$data[0].'\')">'.strtoupper($data[0]).'</a></li>';
		}
	}
}

/**
 * printDisplays, similirarly to showDisplays will print the sections.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param  mixed $datas
 *            an array of array with two element: a string for the tag, the fetched corresponding content fetched earlier.
 * @return void
 */
function printDisplays($datas) {
	foreach ($datas as $data) {
		if($data[1]) { echo $data[1]; }
	}
}
?>