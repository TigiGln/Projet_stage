<?php
//Destroy cookie and session when user disconnect.
session_start() ;
session_destroy();
//We destroy the cookie by seeting an expiracy date that is already in the past
setcookie('connexion', "", time()-3600);
//Redirect to index
header('Location: ./index.php');
?>