<?php
/*
 * Created on Fri Apr 23 2021
 * Latest update on Mon Apr 26 2021
 * Info - readArticle is the common page to use article editing tools that features only a pdf.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

//CLASS IMPORT
include('./POO/class_main_menu.php');
include('./POO/class_edit_article_menu.php');
?>

<?php
include('./views/header.html');

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
	$submenu = (new editArticleMenu($PMCID));
    $submenu->setAnnotate(false); $submenu->setConclude(false);
	$submenu->write();
} else {
	echo '<div class="alert alert-danger" role="alert">
			This page need an argument: ?PMCID=NUM
		</div>';
}
include('./views/footer.html');
?>