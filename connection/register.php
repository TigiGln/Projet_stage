<?php
//CLASS IMPORT
include('../views/header.php');
?>
<?php
    if(isset($_GET['username']) && isset($_GET['email']) && isset($_GET['password']) && isset($_GET['profile'])) {
        $cols = array();
        array_push($cols, array("name_user", $_GET['username']), array("email", $_GET['email']), array("password", password_hash($_GET['password'], PASSWORD_DEFAULT)), array("profile", $_GET['profile']));
        $res = $manager->getSpecific(array("name_user"), array(array("name_user", $_GET['username'])), "user");
        if(!empty($res)) http_response_code(403);
        else {
            $res = $manager->insertSpecific($cols, "user");
            ($res) ? http_response_code(200) : http_response_code(500);
        }
    } else {
        http_response_code(400);
    }
    echo http_response_code();
?>