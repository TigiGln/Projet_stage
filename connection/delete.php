<?php
//CLASS IMPORT
include('../views/header.php');

/*
 * Created on Mon May 17 2021
 * Latest update on Tue May 18 2021
 * Info - PHP for members delete management
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */
?>
<?php
    if(isset($_GET['username']) && isset($_GET['id'])) {
        $cols = array();
        array_push($cols, array("name_user", $_GET['username']), array("id_user", $_GET['id']));
        $res = $manager->getSpecific(array("id_user"), array(array("id_user", $_GET['id'])), "user");
        $check = $manager->getSpecific(array("profile"), array(array("name_user", $_SESSION['username'])), "user")[0]['profile'];
        if(!$res || $check != 'expert') http_response_code(403);
        else {
            //give articles to actual user
            $res = $manager->updateSpecific(array(array("user", $_SESSION['userID'])), array(array("user", $_GET['id'])),"article");
            if(!$res) { http_response_code(500); }
            else {
                //if could give, then delete user
                $res = $manager->deleteSpecific($cols, "user");
                ($res) ? http_response_code(200) : http_response_code(500);
            }
        }
    } else {
        http_response_code(400);
    }
    echo http_response_code();
?>