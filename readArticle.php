<?php
/*
 * Created on Mon Apr 19 2021
 * Latest update on Mon Apr 26 2021
 * Info - readArticle is the common page to use article editing tools that features html/xml code.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

//CLASS IMPORT
require('./POO/class_main_menu.php');
require('./POO/class_edit_article_menu.php');
?>

<?php
include('./views/header.php');
//Menu
(new mainMenu('My_Tasks'))->write();
?>

<!-- show one article to test-->
<div id="article" class="p-4 w-100 overflow-auto" style="height: 100vh;">
<?php
if(isset($_GET['PMCID'])) {
	$PMCID = $_GET['PMCID'];
	include('./utils/FromPMCID.php');
	echo '</div>';
	//Menu
	(new editArticleMenu($PMCID))->write();
} else {
	echo '<div class="alert alert-danger" role="alert">
			This page need an argument: ?PMCID=NUM
		</div>';
}
include('./views/footer.html');
?>