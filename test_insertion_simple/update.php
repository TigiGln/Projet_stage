<?php
    require "../POO/class_connexion.php";
    session_start();
    include('header.html');
?>
<?php
    $menu = "test_fenetre_indefini";
    include("menu.html");
?>
<?php
    require "class_manager_simple.php";
    require "function.php";
    #var_dump($_SESSION["connexionbd"]);
    #echo "<br><br>";
    #var_dump($_GET);
    #echo "<br><br>";
    $liste_argument_statut_url= array_intersect_key($_GET, $_SESSION['list_statut_initial']);
    #var_dump($_SESSION['list_statut_initial']);
    #echo "<br><br>";
    
    $manager = new Manager($_SESSION["connexionbd"]->pdo);#création de l'objet permettant d'agir sur la base de données

    $result_compare = array_diff_assoc($liste_argument_statut_url, $_SESSION['list_statut_initial']);#On vérifie les différences pouvant exister entre les info du statut initial et ceux potentiellement modifié.

    foreach($result_compare as $key => $value)#boucle sur le tableau de résultat de la comparaison pour mettre à jour les profils qui ne match pas avec le stut initial
    {
        $id_recupere = str_replace('statut_', "", $key);#récupération de l'identifiant de la ligne (pmid le plus souvent)
        $manager->update($id_recupere, 'statut', $value);#mise à jour du statut
        

    }
    search_table_statut($_SESSION['statut_page']);
    
?>
<?php      
    include('footer.html');
    session_destroy();
?>