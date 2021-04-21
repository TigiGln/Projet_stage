<?php
include('./views/header.html');
$menu = 'myTasks'; //To save where we are so the menu can add the active tag
//Menu
include('./views/menu.php');
?>
<!-- show one article to test-->
<div id="article" class="p-4 w-100 overflow-auto" style="height: 100vh;">
<?php
if(isset($_GET['PMCID'])) {
	$PMCID = $_GET['PMCID'];
	include('./utils/FromPMCID.php');
	echo '</div>';
	//include('./utils/WYSIWYG/wysiwyg.php');
	include('./views/sideMenu-Articles.php');
} else {
	echo '<div class="alert alert-danger" role="alert">
			This page need an argument: ?PMCID=NUM
		</div>';
}
include('./views/footer.html');
?>