<?php
    
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "../POO/class_article.php";
    require "requete.php";
?>
<?php
    include('../views/header.php');
    #$_SESSION['connexion'] = 'John Doe';
    $menu = new mainMenu('Insertion');
    $menu->write();
?>
<?php
    $list_articles = $_SESSION["list_articles"];

    foreach ($_POST["check"] as $value)
    {
        $OK = $manager->add($list_articles[$value]);
        echo "<p>Article N°" . $value . " a bien été ajouté dans la base de données</p>";
          
    }
    
?>
<?php      
    include('../views/footer.php');
?>