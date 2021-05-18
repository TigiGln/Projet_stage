<?php
//CLASS IMPORT
include('../views/header.php');

/*
 * Created on Mon May 17 2021
 * Latest update on Tue May 18 2021
 * Info - PHP for members register management
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */
?>
<?php
    if(isset($_GET['username']) && isset($_GET['email']) && isset($_GET['password']) && isset($_GET['profile'])) {
        $cols = array();
        array_push($cols, array("name_user", $_GET['username']), array("email", $_GET['email']), array("password", password_hash($_GET['password'], PASSWORD_DEFAULT)), array("profile", $_GET['profile']));
        $res = $manager->getSpecific(array("name_user"), array(array("name_user", $_GET['username'])), "user");
        $check = $manager->getSpecific(array("profile"), array(array("name_user", $_SESSION['username'])), "user")[0]['profile'];
        if(!empty($res) || $check != 'expert') http_response_code(403);
        else {
            $res = $manager->insertSpecific($cols, "user");
            ($res) ? http_response_code(200) : http_response_code(500);
        }
    } else {
        http_response_code(400);
    }
    echo http_response_code();
?>