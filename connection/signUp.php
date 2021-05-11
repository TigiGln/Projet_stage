<?php
//CLASS IMPORT
require('../POO/class_main_menu.php');
?>

<?php
include('../views/header.php');
//Menu
(new mainMenu('Members_Management', $manager))->write();

//Database
$user = $_SESSION['username'];
$userID = $_SESSION['userID'];
?>
<div class="flex p-4 w-100 overflow-auto" style="height: 100vh;">
<h1>Register a new member</h1> 
  <form class="pt-4" method="get" action="register.php" enctype="multipart/form-data">
      <div class="form-group pb-4">
      <label for="name_user">Username</label>
        <input class="form-control w-25" type="text" name="name_user" id="name_user" required>
      </div>
      <div class="form-group pb-4">
      <label for="email">Email</label>
        <input class="form-control w-25" type="email" name="email" id="email" required>
      </div>
      <div class="form-group pb-4">
      <label for="password">Password</label>
        <input class="form-control w-25" type="password" name="password" id="password" required>
      </div>
      <div class="form-group pb-4">
      <label>Profile</label>
      <select class="form-select w-25" name="profile" id="profile" required>
          <option value="expert">Expert</option>
          <option value="assistant">Assistant</option>
      </select>
      </div>
      <div class="form-group pb-4">
        <input class="btn btn-outline-success" type="submit" value="Enregistrer">
      </div>
  </form>
</div>
<?php
include('../views/footer.php');
?>