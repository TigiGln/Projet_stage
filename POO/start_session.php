<?php
require "class_connexion.php";

if (!isset($_SESSION["connexionbd"]))
{
	//Si la session n'existe pas mais un cookie existe avec les infos
	//Si chaque personne a un ID unique -> Fonction de cryptage avec ID et ou mdp
	//sinon username et mdp (peut on avoir 2 meme user ?) -> Utiliser l'adresse mail
	//Adresse mail comme valeur du cookie encrypter, si le cookie existe decrypter
	//Et faire la connexion automatiquement pour la session.
	//Sinon connecter

	//Question: La base fournis sur le pdf a un user id en primary key
	//Donc 2 user peuvent avoir le meme nom, ce qui reste normal (?)
	//-> user = email ? Je pense que ce serait judicieux comme ça
	//Ou alors ajout d'un autre champ qui permet d'avoir 2 meme nom
	//Mais pas 2 mail similaire
	//-> Connection avec mail : mdp
    $connexionbd = new ConnexionDB("localhost", "stage", "thierry", "Th1erryG@llian0");
    $_SESSION["connexionbd"] = $connexionbd;

    #echo "Actualiser la page";
}
/*else
{
    echo "<pre>";
    var_dump($_SESSION["connexion"]); // On affiche les infos concernant notre objet.
    echo "</pre>";
}

//Destroy la session lors du disconnect.
session_destroy()
*/
?>