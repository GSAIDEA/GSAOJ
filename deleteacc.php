<?php
	require_once("include/db_info.php");
	require_once("include/setlang.php");
	require_once("include/include_auth.php");
?>
<!doctype html>
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
    if(!$auth->isLogged()){
        header('HTTP/1.0 403Forbidden');
        echo "<script type='text/javascript'>alert('".$MSG_ERR_NOT_LOGGEDIN."');</script>";

        echo "<script type='text/javascript'>window.location = \"./index.php\";</script>";
    }

    if(isset($_POST['passwd'])){
	if(!$auth->isLogged()){
	    header('HTTP/1.0 403 Forbidden');
	    echo $MSG_ERR_NOT_LOGGEDIN;
	    die();
	}
	$uid = $auth->getSessionUID($auth->getSessionHash());
	$passwd = $_POST['passwd'];
        $result = $auth->deleteUser($uid, $passwd);
        if($result['error']){
            echo $result['message'];
	    die();
        }
	try{
	    $res = $db_conn->prepare("DELETE from userdata where uid=?");
	    $res->execute(array($uid));
	    $res = $db_conn->prepare("DELETE from submit where uid=?");
	    $res->execute(array($uid));
	} catch(PDOException $e){
	    echo $e->getMessage();
	}
	echo "<script>window.location = \" ./index.php\";</script>";
    }
    ?>

    <main role="main">
      <div class="container">
        <form class="form-register" action="deleteacc.php" method="post">
          <h2 class="margin-bottom-20"><?php echo $MSG_DELETE_ACCOUNT;?></h2>
          <label for="inputPassword"><?php echo $MSG_LOGIN_PW?></label>
          <input type="password" name="passwd" class="form-control" placeholder="" required>
          <button class="btn btn-primary btn-block" type="submit"><?php echo $MSG_DELETE_ACCOUNT;?></button>
        </form>
      </div>
    </main>

    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
