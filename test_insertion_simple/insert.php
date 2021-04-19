<?php
    require "class_manager_simple.php";
    require "class_article_simple.php";
    require "../POO/class_connexion.php";
    session_start();
    
    if ($_SESSION != [])
    {
        $liste = $_SESSION["liste"];
        #var_dump($liste);
        if (isset($_GET["check"]) AND $_GET["check"] != [])
        {
            #var_dump($_GET["check"]);
            #echo "<p></p>";
            
            $manager = new Manager($_SESSION["connexion"]->pdo);
            foreach ($_GET["check"] as $value)
            {
                
                if (array_key_exists($value, $liste))
                {
                    if ($manager->get_exist("pub_db_acc" , $liste[$value]->pmid()))
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
    echo "<p><a href='form.php'>Back to insert page</a></p>";
    session_destroy();
?>