<!--
Formulaire pour la connexion
-->

<!DOCTYPE html >
<html lang="en">
    <head>
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
        <link rel="icon" href="/Projet_stage/pictures/ico.ico" />
        <link href="../css/signIn.css" rel="stylesheet">
        <!--<link href="../css/style.css" rel="stylesheet">-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link href="../css/redefinebootstrap.css" rel="stylesheet">
        <meta charset="utf-8" />
        <title>Page de connexion</title>
    </head>
    <body>
        <form method="get" action="form_connexion.php">

            <p class="form-floating">
                <input class="form-control" type="text" name="name_user" id="name_user"> 
                <label for="name_user">Pseudo</label>
            </p>
            <p class="form-floating">
                <input class="form-control" type="password" name="password" id="password">
                <label for="password">Password</label>
            </p>
            <button class="w-100 btn btn-lg btn-outline-primary" type="submit">Connexion</button>
            <p class="checkbox_mb-3">
                <input type="checkbox" value="remember-me"> Connect me Automatically
            </p>
        </form>
        <?php
        /*Script pour la vérification de la connexion à une session. démarre une session et crée les variable d'environnement.
        */
            require "../../Projet_stage/POO/class_connexion.php";
            require "../../Projet_stage/POO/class_manager_bd.php";
            if(isset($_GET['name_user']) AND isset($_GET['password']))
            {
                $connexion = new ConnexionDB('localhost', 'biblio', $_GET['name_user'], $_GET['password']);
                if ($connexion->pdo != Null)
                {
                    session_start();
                    $_SESSION['connexiondb'] = $connexion;
                    header('Location:../../Projet_stage/trie_table_statut/page_table.php?status=undefined&user=' . $_GET['name_user']);
                }
                else
                {
                    header('Location:./form_connexion.php');
                }
            }

        ?>
    </body>
</html>