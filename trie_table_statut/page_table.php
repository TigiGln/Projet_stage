<?php
    
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "function.php";
?>
<?php
    include('../views/header.php');
    $_SESSION['connexion'] = 'John Doe';
    $menu = new mainMenu('My Tasks');
    $menu->write();
?>

<form method="get" action="update.php" enctype="multipart/form-data">
    <div class='p-4 w-100'>
        <?php
            #connexion à la base de données
            $connexionbd = new ConnexionDB("localhost", "biblio", "thierry", "Th1erryG@llian0");
            $_SESSION["connexionbd"] = $connexionbd;
            $_SESSION['status_page'] = $_GET["status"];#Enregistrement du staut de la page dans une variable de session
            $list_status_initial = search_table_status($_GET["status"]);#affichage de notre tableau en fonction du statut
            $_SESSION['list_status_initial'] = $list_status_initial;#on insère notre liste de statut initial dans une variable d'environnement qui suit tous le long de la session.
        ?>
    </div>
</form>
<?php      
    include('../views/footer.html');
?>
