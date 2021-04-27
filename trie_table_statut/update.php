<?php
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "function.php";
    session_start();
?>
<?php
    include('../views/header.html');
    $menu = new mainMenu('My Tasks');
    $menu->write();
?>
<?php
    
    #var_dump($_SESSION["connexionbd"]);
    #echo "<br><br>";
    #var_dump($_SESSION);
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
    include('../views/footer.html');
    session_destroy();
?>