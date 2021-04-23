<!--
Formulaire pour la connexion
-->

<!DOCTYPE html >
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Page de connexion</title>
        <style>
            form
            {
                text-align: center;
                
            }

        </style>
    </head>
    <body>
        <form method="get" action="form_connexion.php" enctype="multipart/form-data">
            <p>
                <input type="email" name="email" id="email">
                <label for="email">Email</label>
            </p>
            <p>
                <input type="password" name="password" id="password">
                <label for="password">Password</label>
            </p>
            <p>
                <input type="submit" value="Connexion">
            </p>
        </form>
        <?php
        /*Script pour la vérification de la connexion à une session. démarre une session et crée les variable d'environnement.
        */
            require "../../Biblio/classe_connexion_session.php";
            require "../test_insertion_simple/class_manager_simple.php";
            if(isset($_GET["email"]) AND isset($_GET["password"]))
            {
                $connexion = new Connexion($_GET["email"], $_GET["password"]);
                $_SESSION['connexion'] = $connexion;
                $connexion_db = $connexion->connexionBDD("localhost", "stage", "thierry", "Th1erryG@llian0");
                $_SESSION['connexionBD'] = $connexion_db;
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
    </body>
</html>