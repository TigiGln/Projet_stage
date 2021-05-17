<?php
//CLASS IMPORT
require('../POO/class_main_menu.php');
/*
 * Created on Mon May 17 2021
 * Latest update on Mon May 17 2021
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @author Thierry Galliano
 */
include('../views/header.php');
//Menu
(new mainMenu('Members_Management', $manager))->write();
?>

<div class="flex p-4 w-100 overflow-auto" style="height: 100vh;">
<h1>Members Management</h1> 
<div id="info"><!----></div>
<div class="row justify-content-start">
    <div class="col-md-auto">
        <button id="addForm" type="button" class="formButton btn btn-outline-info" onclick="showAddForm()">Add Member</button>
    </div>
    <div class="col">
        <button id="manageForm" type="button" class="formButton btn btn-outline-info" onclick="showManageForm()">Manage Members</button>
    </div>
</div>
<div id="form"><!----></div>
<div id="formBis"><!----></div>
</div>
<script src="management.js"></script> 
<?php
include('../views/footer.php');
?>