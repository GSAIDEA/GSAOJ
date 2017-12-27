<?php
require_once "../include/db_info.php";
require_once "../include/setlang.php";
require_once "../include/include_auth.php";
if (!$auth->isLogged()) {
    echo "<script type='text/javascript'>alert('something wrong'); window.history.back();</script>";
    die();
}
$check_id = $auth->getSessionUID($auth->getSessionHash());
$res = $db_conn->prepare("select privilege.type from privilege left join users on privilege.id=users.id where users.id=?");
$res->execute(array($check_id));
$privilege = $res->fetch(PDO::FETCH_ASSOC)['type'];
if (strcmp($privilege, "admin") != 0) {
    echo "<script type='text/javascript'>alert('something wrong2'); window.history.back();</script>";
    die();
}
