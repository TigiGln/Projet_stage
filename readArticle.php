<?php
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
	(new editArticleMenu($PMCID))->write();
} else {
	echo '<div class="alert alert-danger" role="alert">
			This page need an argument: ?PMCID=NUM
		</div>';
}
include('./views/footer.html');
?>