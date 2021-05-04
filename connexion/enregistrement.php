<?php
/*
insertion de nouvel utilisateur dans la base de données user
*/
    require "../POO/class_connexion.php";
    require "../../Projet_stage/POO/class_manager_bd.php";
    //require "../test_insertion_simple/class_manager_simple.php";
    if(isset($_GET['name_user']) AND isset($_GET["email"]) AND isset($_GET["password"]) AND isset($_GET["profile"]))
    {
        $connexion = new ConnexionDB("localhost", "biblio", "thierry", "Th1erryG@llian0");
        $manager = new Manager($connexion->pdo);
        $attribut = array_keys($_GET);
        /*var_dump($attribut);
        echo "<br>";
        var_dump($_GET);*/
        //echo $_GET["name_user"];
        if ($manager->get_exist('user', 'name_user' , $_GET["name_user"]))
        {
            echo "Cet utilisateur est déjà dans la base";
        }
        else
        {
            $manager->add_form($_GET, $attribut, "user");
            echo "<p>L'utilisateur a bien été ajouté dans la base de données</p>";
        }
    }

?>