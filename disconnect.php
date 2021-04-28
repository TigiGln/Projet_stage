<?php
/*
 * Created on Fri Apr 16 2021
 * Latest update on Mon Apr 26 2021
 * Info - disconect script that kill the cookie and the session when disconnecting and redirect to index
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

session_start() ;

session_destroy();
setcookie('connexion', "", time()-3600);

header('Location: ./index.php');
?>