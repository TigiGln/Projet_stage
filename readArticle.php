<?php
include('./views/header.html');
$menu = 'myTasks'; //To save where we are so the menu can add the active tag
//Menu
include('./views/menu.php');
?>
<!-- show one article to test-->
<div class="p-4 w-75">
<?php
if(isset($_GET['PMCID'])) {
	$PMCID = $_GET['PMCID'];//"7934857"; //"7531976"; "7934857"; 7857568
	include('./utils/FromPMCID.php');
	echo '</div>';
	include('./utils/WYSIWYG/wysiwyg.html');
} else {
	echo '<div class="alert alert-danger" role="alert">
			This page need an argument: ?PMCID=NUM
		</div>';
}
include('./views/footer.html');
?>