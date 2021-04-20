<?php

require "class_connexion.php";
session_start();

if (!isset($_SESSION["connexion"]))
{
    $connexion = new Connexion("localhost", "stage", "thierry", "Th1erryG@llian0");
    $_SESSION["connexion"] = $connexion;

    echo "Actualiser la page";
}
else
{
    echo "<pre>";
    var_dump($_SESSION["connexion"]); // On affiche les infos concernant notre objet.
    echo "</pre>";
}

#session_destroy()
?>