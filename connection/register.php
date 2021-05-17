<?php
//CLASS IMPORT
include('../views/header.php');
?>
<?php
    if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['profile'])) {
        $cols = array();
        array_push($cols, array("name_user", $_POST['username']), array("email", $_POST['username']), array("password", password_hash($_POST['password'], PASSWORD_DEFAULT)), array("profile", $_POST['profile']));
        $res = $manager->insertSpecific($cols, "user")
    } else {
        http_response_code(400);
    }
?>