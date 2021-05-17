<?php
//CLASS IMPORT
include('../views/header.php');
?>
<?php
    if(isset($_GET['username']) && isset($_GET['email']) && isset($_GET['password']) && isset($_GET['profile']) && isset($_GET['id'])) {
        $cols = array();
        array_push($cols, array("name_user", $_GET['username']), array("email", $_GET['email']), array("profile", $_GET['profile']));
        if(!empty($_GET['password'])) {
            array_push($cols, array("password", password_hash($_GET['password'], PASSWORD_DEFAULT)));
        }
        $res = $manager->getSpecific(array("id_user"), array(array("id_user", $_GET['id'])), "user");
        if(!$res) http_response_code(403);
        else {
            $cond = array(array("id_user", $_GET['id']));
            $res = $manager->updateSpecific($cols, $cond, "user")
            ($res) ? http_response_code(200) : http_response_code(500);
        }
    } else {
        http_response_code(400);
    }
    echo http_response_code();
?>