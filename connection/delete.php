<?php
//CLASS IMPORT
include('../views/header.php');
?>
<?php
    if(isset($_GET['username']) && isset($_GET['id'])) {
        $cols = array();
        array_push($cols, array("name_user", $_GET['username']), array("id_user", $_GET['id']));
        $res = $manager->getSpecific(array("id_user"), array(array("id_user", $_GET['id'])), "user");
        if(!$res) http_response_code(403);
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