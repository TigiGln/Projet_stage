<?php
/*
insertion de nouvel utilisateur dans la base de données user
*/
    require "../POO/class_connexion.php";
    require "../test_insertion_simple/class_manager_simple.php";
    if(isset($_GET["email"]) AND isset($_GET["password"]) AND isset($_GET["profils"]))
    {
        $connexion = new Connexion("localhost", "stage", "thierry", "Th1erryG@llian0");
        $manager = new Manager($connexion->pdo);
        $attribut = array_keys($_GET);
        if ($manager->get_exist("email" , $_GET["email"], "user_test"))
        {
            echo "Cette adresse est déjà dans la base";
        }
        else
        {
            $manager->add_form($_GET, $attribut, "user_test");
            echo "<p>L'utilisateur a bien été ajouté dans la base de données</p>";
        }
    }

?>