<?php
    //import des fichiers de classes et de functions
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "function.php";
?>
<?php
    include('../views/header.php');//inclusion de l'entête
    $menu = new mainMenu($_GET['status']);//creation du menu
    $menu->write();//ecriture des éléments du menu
?>
<!--<form method="get" action="update.php" enctype="multipart/form-data">-->
    <div class="flex p-4 w-100 overflow-auto" style="height: 100vh;">
        <?php
            #connexion à la base de données
            $connexionbd = new ConnexionDB("localhost", "biblio", "root", "");
            $_SESSION["connexiondb"] = $connexionbd;
            $manager = new Manager($_SESSION["connexiondb"]->pdo);#création de l'objet permettant d'agir sur la base de données
            $_SESSION['status_page'] = $_GET["status"];#Enregistrement du staut de la page dans une variable de session
            $list_status_initial = search_table_status($_GET["status"], $_SESSION['username'], $manager);#affichage de notre tableau en fonction du statut
            $_SESSION['list_status_initial'] = $list_status_initial;#on insère notre liste de statut initial dans une variable d'environnement qui suit tous le long de la session.
        ?>
    </div>
<!--</form>-->
<script src="./sort_status.js"></script>
<?php      
    include('../views/footer.php');//inclusion du pied de page
?>
