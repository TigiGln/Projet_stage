<?php
/*Script pour la vérification de la connexion à une session. démarre une session et crée les variable d'environnement.
*/
    require "../POO/class_connexion.php";
    require "../test_insertion_simple/class_manager_simple.php";
    if(isset($_GET["email"]) AND isset($_GET["password"]))
    {
        $connexion = new ConnexionDB("localhost", "stage", "thierry", "Th1erryG@llian0");
        $_SESSION['connexion'] = $connexion;
        $manager = new Manager($connexion->pdo);
        $result = $manager->get("email", $_GET["email"], "user_test");
        if (!empty($result))
        {
            if ($result["email"] == $_GET["email"] AND $result["password"] == $_GET["password"])
            {
                session_start();
                $_SESSION['email'] = $_GET["email"];
                $_SESSION['password'] = $_GET["password"];
                echo "Votre session est active";
                #var_dump($_SESSION);
                header('Location: ../../Biblio/index.php');
                
            }
            else
            {
                echo "Mot de passe incorrect";
                include("./form_connexion.php");
            }
        }
        else
        {
            
            echo "vous n'êtes pas un utilisateur enregistré";
            include("./form_connexion.php");
            
        }

    }

?>