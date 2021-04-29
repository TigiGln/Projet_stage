<?php
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "function.php";
?>
<?php
    include('../views/header.php');//j'inclus le header
    $menu = new mainMenu('My_Tasks');//création du de l'objet menu
    $menu->write();//écriture des différents éléments du menu
?>
<?php
    $manager = new Manager($_SESSION["connexionbd"]->pdo);#création de l'objet permettant d'agir sur la base de données
    //echo "<pre>";
    //var_dump($_GET);
    //echo "</pre>";
    $manager->update($_GET['id'], 'status', $_GET['status'], 'article');#mise à jour du statut


    echo "<div class='p-4 w-100'>";
    search_table_status($_SESSION['status_page']); // rechargement de la table
    #header('Location:page_table.php?status=' . $_SESSION['status_page']);
    echo "</div>";
?>
<?php      
    include('../views/footer.html');//j'inclus le footer
?>