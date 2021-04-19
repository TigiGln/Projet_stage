<?php
include('./views/header.html');
$menu = 'myTasks'; //To save where we are so the menu can add the active tag
//Menu
include('./views/menu.php');
?>
<!-- show one article to test-->
<div class="p-4 w-75">
<?php
include('./utils/FromPMCID.php');
?>
</div>
<?php
//champ WYSIWYG
include('./utils/WYSIWYG/wysiwyg.html');
include('./views/footer.html');
?>