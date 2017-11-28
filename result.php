<?php
require "./include/db_info.php";
require "./include/include_auth.php";
require "./include/setlang.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $OJ_NAME;?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php require("importcss.php");?>

  </head>
  <body>
    <!-- navbar -->
    <?php require("nav.php");
if(!$auth->isLogged()) {
	header('HTTP/1.0 403Forbidden');
	echo "<script type='text/javascript'>alert('".$MSG_ERR_NOT_LOGGEDIN."');</script>";
	echo "<script type='text/javascript'>window.location='index.php';</script>";
}
if(!isset($_GET['submitid'])) {
	header('HTTP/1.0 403Forbidden');
	echo "<script type='text/javascript'>alert('".sprintf($MSG_ERR_NOT_FOUND, $MSG_STATUS_SUBMITID)."');</script>";
	echo "<script type='text/javascript'>window.location='index.php';</script>";
}
$stmt = $db_conn->prepare("select uid, status from submit where submit_id=:sub");
$stmt->execute([":sub"=>$_GET['submitid']]);
$res = $stmt->fetch();
if($res['uid'] != $auth->getSessionUID($auth->getSessionHash())){
	header('HTTP/1.0 403Forbidden');
	echo "<script type='text/javascript'>alert('".$MSG_ERR_WRONG_APPROACH."');</script>";
	echo "<script type='text/javascript'>window.location='index.php';</script>";
}
    ?>
  </body>
</html>
