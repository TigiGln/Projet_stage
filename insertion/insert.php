<?php
    
    require "../POO/class_main_menu.php";
    require "../POO/class_article.php";
    require "request.php";
?>
<?php
    include('../views/header.php');
    $menu = new MainMenu('Insertion', $manager);
    $menu->write();
?>
<div class="flex p-4 w-100 overflow-auto" style="height: 100vh;">
<?php
    
    if ($_SESSION != [])#Vérification que la session est en cours
    {
        $list_articles = $_SESSION["list_articles"];
        #var_dump($liste);
        if (isset($_GET["check"]) AND $_GET["check"] != [])
        {
            foreach ($_GET["check"] as $value)
            {
                $manager->add($list_articles[$value]);
                echo '<div class="alert alert-info" role="alert">Article N°'. $value .' was successfully added to the database</div>';
            }
        }
        
        
    }
?>
</div>
<?php      
    include('../views/footer.php');
?>