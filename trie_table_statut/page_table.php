<?php
    //import des fichiers de classes et de functions
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "function.php";
?>
<?php
    include('../views/header.php');//inclusion
    $_SESSION['connexion'] = 'John Doe';
    $menu = new mainMenu($_GET['status']);//creation du menu
    $menu->write();//ecriture des éléments du menu
?>

<form method="get" action="update.php" enctype="multipart/form-data">
    <div class='p-4 w-100'>
        <?php
            #connexion à la base de données
            $connexionbd = new ConnexionDB("localhost", "biblio", "thierry", "Th1erryG@llian0");
            $_SESSION["connexionbd"] = $connexionbd;//Enregistrement de la conexxion pour le transfert aux page par variable d'environnement
            $_SESSION['status_page'] = $_GET["status"];#Enregistrement du staut de la page dans une variable de session
            $_SESSION['user'] = $_GET['user'];
            $list_status_initial = search_table_status($_GET["status"], $_GET['user']);#affichage de notre tableau en fonction du statut
            $_SESSION['list_status_initial'] = $list_status_initial;#on insère notre liste de statut initial dans une variable d'environnement qui suit tous le long de la session.
        ?>
    </div>
</form>
<?php      
    include('../views/footer.html');//inclusion
?>
