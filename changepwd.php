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
    <?php     
    require("nav.php");
    if(!$auth->isLogged()){
      header('HTTP/1.0 403Forbidden');
      echo "<script type='text/javascript'>alert('".$MSG_ERR_NOT_LOGGEDIN."');</script>";
      echo "<script type='text/javascript'>window.location = \"./index.php\";</script>";
    }
    if(isset($_POST['curpw']) && isset($_POST['newpw']) && isset($_POST['newpwvf'])){
	    $uid = $auth->getSessionUID($auth->getSessionHash());
      $curpw = $_POST['curpw'];
      $newpw = $_POST['newpw'];
      $newpwvf = $_POST['newpwvf'];
      $result = $auth->changePassword($uid, $curpw, $newpw, $newpwvf);
      if($result['error']){
        echo "<script>alert(\"".$result['message']."\")</script>";
      }
	    else{
        echo "<script>alert(\"".$result['message']."\")</script>";
	      echo "<script type='text/javascript'>window.location = \" ./index.php\";</script>";
	    }
    }
    ?>

    <main role="main">
      <div class="container">
        <form class="form-register" action="changepwd.php" method="post">
          <h2 class="margin-bottom-30"><?php echo $MSG_CHANGE_PASSWORD;?></h2>
          <label for="inputCurPw"><?php echo $MSG_CUR_PASSWORD;?></label>
          <input type="password" name="curpw" class="form-control margin-bottom-20" placeholder="<?php echo $MSG_CUR_PASSWORD;?>" required>
          <label for="inputNewPw"><?php echo $MSG_NEW_PASSWORD?></label>
          <input type="password" name="newpw" class="form-control margin-bottom-20" placeholder="<?php echo $MSG_NEW_PASSWORD;?>" required>
          <label for="inputNewPwVf"><?php echo $MSG_NEW_PASSWORD_VERIFY?></label>
          <input type="password" name="newpwvf" class="form-control margin-bottom-20" required>
          <button class="btn btn-primary btn-block" type="submit"><?php echo $MSG_CHANGE_SUBMIT;?></button>
        </form>
      </div>
    </main>

    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>
