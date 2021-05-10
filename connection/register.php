<?php
//CLASS IMPORT
require('../POO/class_main_menu.php');
require('../POO/class_connexion.php');
require("../POO/class_manager_bd.php");
include('../views/header.php');
//Menu
(new mainMenu('Add_Member'))->write();

?>
<div class="flex p-4 w-100 overflow-auto" style="height: 100vh;">
<?php
    if(isset($_GET['name_user']) AND isset($_GET["email"]) AND isset($_GET["password"]) AND isset($_GET["profile"]))
    {
        $connexion = new ConnexionDB("localhost", "biblio", "root", "");
        $manager = new Manager($connexion->pdo);
        $attribut = array_keys($_GET);
        if ($manager->get_exist('user', 'name_user' , $_GET["name_user"])) {
            echo '<div class="alert alert-danger" role="alert">A similar user already exist in the database.</div>';
        }
        else {
            $manager->add_form($_GET, $attribut, "user");
            echo '<div class="alert alert-info" role="alert">successfully created a user profile for the member '.$_GET['name_user'].' (level: '.$_GET["profile"].').</div>';
        }
    }
?>
</div>
<?php
include('../views/footer.php');
?>