<?php
require (__DIR__."/../PHPAuth/Config.php");
require (__DIR__."/../PHPAuth/Auth.php");
require (__DIR__."/../include/db_info.php");
$config = new PHPAuth\Config($db_conn);
$auth   = new PHPAuth\Auth($db_conn, $config);
/*function isAdmin($request = NULL){
	global $db_conn, $auth;
	if(!isset($request)){
		$verify_stmt=$db_conn->prepare("select usertype from userdata where id=:userid");
		$userid = $auth->getUser($auth->getSessionUID($auth->getSessionHash()));
	        $verify_stmt->execute(array(":userid"=>$userid['userid']));
	}
	else{
		$verify_stmt=$db_conn->prepare("select usertype from userdata where id=:userid");
		$verify_stmt->execute(array(":userid"=>$request));
	}

        $usertype = $verify_stmt->fetch()['usertype'];
	if($usertype == 1){
		return true;
	}
	else return false;

}*/
?>
