<?php
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "function.php";
?>
<?php
    include('../views/header.php');//j'inclus le header
?>
<?php
    #création de l'objet permettant d'agir sur la base de données
    //$manager = new Manager($_SESSION["connexiondb"]->pdo);//création de l'objet de gestion des requête sql
    $manager->update($_GET['num_acces'], $_GET['fields'], $_GET[$_GET['fields']], 'article', $_GET['fields']);#mise à jour dans la base de données du champs (status ou user) modifié
    if ($_GET['fields'] == 'user')//vérifie que le menu déroulant changer correspond aux user
    {
        if($_GET['valueStatusInitial'] == 'reject' OR $_GET['valueStatusInitial'] == 'treat' )
        {
            $manager->update($_GET['num_acces'], 'status', 'undefined', 'article', 'status');#mise à jour du status
        }
    }
    
    /*echo 'Hello';
    echo "<div class='p-4 w-100'>";
    //search_table_status($_GET['valueStatusInitial'], $_SESSION['user'], $manager); // rechargement de la table
    //header('Location:page_table.php?status=' . $_GET['valueStatus'] '&user=' . $_SESSION['user']);
    echo "</div>";*/
?>
