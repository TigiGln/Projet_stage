<?php
  if(!class_exists("ConnexionDB")) require($position."/POO/class_connexion.php");
  if(!class_exists("Manager")) require($position."/POO/class_manager_bd.php");
  if(!class_exists("UserConnection")) require($position."/POO/class_userConnection.php");
  
  $userConnection = new UserConnection(true);
  $userConnection->isValid();
  if(isset($_SESSION['connexiondb'])) { $manager = new Manager($_SESSION["connexiondb"]->pdo); }   
  else {
    $_SESSION['connexiondb'] = new ConnexionDB("localhost", "biblio", 3306, "root", "");
    $manager = new Manager($_SESSION['connexiondb']->pdo);
  }
?>