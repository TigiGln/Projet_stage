<?php
    require $_SERVER["DOCUMENT_ROOT"]."/POO/class_main_menu.php";
    require $_SERVER["DOCUMENT_ROOT"]."/POO/class_connexion.php";
    require $_SERVER["DOCUMENT_ROOT"]."/POO/class_manager_bd.php";
    require "function.php";
?>
<?php
    include($_SERVER["DOCUMENT_ROOT"].'/views/header.html');
    $menu = new mainMenu('My_Tasks');
    $menu->write();
?>

<form method="get" action="update.php" enctype="multipart/form-data">
    <div class='p-4 w-100'>
        <?php
            #connexion à la base de données
            $connexionbd = new ConnexionDB("localhost", "stage", "thierry", "Th1erryG@llian0");
            $_SESSION["connexionbd"] = $connexionbd;
            $_SESSION['statut_page'] = $_GET["statut"];#Enregistrement du staut de la page dans une variable de session
            $liste_statut_initial = search_table_statut($_GET["statut"]);#affichage de notre tableau en fonction du statut
            $_SESSION['list_statut_initial'] = $liste_statut_initial;#on insère notre liste de staut initial dans une variable d'environnement qui suit tous le long de la session.
        ?>
        <p>
            <input type="submit" value="Enregistrer">
        </p>
    </div>
</form>
<?php      
    include($_SERVER["DOCUMENT_ROOT"].'/views/footer.html');
?>
