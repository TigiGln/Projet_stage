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
    
    if ($_SESSION != [])
    {
        $list_articles = $_SESSION["list_articles"];
        #var_dump($liste);
        if (isset($_GET["check"]) AND $_GET["check"] != [])
        {
            #var_dump($_GET["check"]);
            #echo "<p></p>";
            
            $manager = new Manager($_SESSION["connexionbd"]->pdo);
            echo '<div class="p-4 w-100 overflow-auto" style="height: 100vh;">';
            foreach ($_GET["check"] as $value)
            {
                
                if (array_key_exists($value, $list_articles))
                {
                    if ($manager->get_exist("num_access" , $list_articles[$value]->num_access(), "article"))
                    {
		                echo "L'article N°" . $value . " est déjà dans la base";
                    }
                    else
                    {
                        #var_dump($list_articles[$value]);
                        $manager->add($list_articles[$value]);
                        echo "<p>Article N°" . $value . " a bien été ajouté dans la base de données</p>";
                        #echo $list_articles[$value];
                    }
                }
            }
            echo '</div>';
        }
        
        
    }
?>
<?php      
    include('../views/footer.html');
?>