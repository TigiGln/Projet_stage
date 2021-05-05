<?php
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "function.php";
?>
<?php
    include('../views/header.php');
    $menu = new mainMenu('My Tasks');
    $menu->write();
?>
<?php
    
    #var_dump($_SESSION["connexionbd"]);
    #echo "<br><br>";
    #var_dump($_SESSION);
    #echo "<br><br>";
    $list_argument_status_url= array_intersect_key($_GET, $_SESSION['list_status_initial']);#Récupération des données du get ayant la clé status
    #echo "<pre>";
    #var_dump($_GET);
    #echo "</pre>";
    #echo "<br><br>";
    
    $manager = new Manager($_SESSION["connexionbd"]->pdo);#création de l'objet permettant d'agir sur la base de données

    $result_compare = array_diff_assoc($list_argument_status_url, $_SESSION['list_status_initial']);#On vérifie les différences pouvant exister entre les info du statut initial et ceux potentiellement modifié.
    #echo "<pre>";
    #var_dump($result_compare);
    #echo "</pre>";
    foreach($result_compare as $key => $value)#boucle sur le tableau de résultat de la comparaison pour mettre à jour les profils qui ne match pas avec le statut initial
    {
        #echo $key . '=>' . $value . "<br>";
        $id_recupere = str_replace('status_', "", $key);#récupération de l'identifiant de la ligne (pmid le plus souvent)
        $manager->update($id_recupere, 'status', strval($value), 'article');#mise à jour du statut
    }
    echo "<div class='p-4 w-100'>";
    search_table_status($_SESSION['status_page']);
    #header('Location:page_table.php?status=' . $_SESSION['status_page']);
    echo "</div>";
?>
<?php      
    include('../views/footer.html');
    session_destroy();
?>