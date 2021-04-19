<?php
include('./views/header.html');

//Security for now: if the cookie isn't set
$menu = 'myTasks'; //To save where we are so the menu can add the active tag
//Menu
include('./views/menu.php');
?>
<!-- MyTask Tab -->
<!-- popover example, juste pour que tu vois comment gerer, tu pourras enlever cette div après elle sers a rien -->
<div class="p-4 w-100">
  <a style="border-style: double;" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-placement="right" data-bs-content='
    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."'>
    <u>Notes:</u> Survole moi...
  </a>
</div>
<?php
include('./views/footer.html');
?>