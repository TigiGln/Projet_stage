<?php
require "../POO/class_main_menu.php";
require "../POO/class_connexion.php";
require "../POO/class_manager_bd.php";

?>
<?php

    include('../views/header.php');//j'inclus le header
?>
<?php

//$list_num_access = json_decode($_GET['listNumAccess']);

//$list_num_access1 = ["54", "55", '53'];
/*echo "<pre>";
var_dump($list_num_access1);
echo "</pre>";
echo "<br><br>";*/
$manager = new Manager($_SESSION["connexionbd"]->pdo);#création de l'objet permettant d'agir sur la base de données

$list_num_access_bd = $manager->get_test('num_access', 'article');

$list_num_access_bd = array_values($list_num_access_bd);

echo "<pre>";
var_dump($list_num_access_bd);
echo "</pre>";

//$list_intersect = array_diff($list_num_access, $list_num_access_bd);

//$list_int = json_encode($list_intersect);

//echo $list_int;






?>