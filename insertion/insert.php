<?php
    
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "../POO/class_article.php";
    require "requete.php";
    session_start();
?>
<?php
    include('../views/header.html');
    #$_SESSION['connexion'] = 'John Doe';
    $menu = new mainMenu('My Tasks');
    $menu->write();
?>
<?php
    
    if ($_SESSION != [])
    {
        $liste = $_SESSION["liste"];
        #var_dump($liste);
        if (isset($_GET["check"]) AND $_GET["check"] != [])
        {
            #var_dump($_GET["check"]);
            #echo "<p></p>";
            
            $manager = new Manager($_SESSION["connexionbd"]->pdo);
            foreach ($_GET["check"] as $value)
            {
                
                if (array_key_exists($value, $liste))
                {
                    if ($manager->get_exist("pub_db_acc" , $liste[$value]->pmid(), "document"))
                    {
		                echo "L'article N°" . $value . " est déjà dans la base";
                    }
                    else
                    {
                        #var_dump($liste[$value]);
                        $manager->add($liste[$value]);
                        echo "<p>Article N°" . $value . " a bien été ajouté dans la base de données</p>";
                        #echo $liste[$value];
                    }
                }
            }
        }
        
        
    }
    session_destroy();
?>
<?php      
    include('../views/footer.html');
?>