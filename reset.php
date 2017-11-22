<?php
	require_once("include/db_info.php");
	require_once("include/setlang.php");
	require_once("include/include_auth.php");
?>
<!doctype html>
<html lang="ko">
  <head>

    <title><?php echo $OJ_NAME;?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php 
    require("importcss.php");
    require("nav.php");
    ?>
  </head>
  <body>
    <?php
    if(isset($_POST['key']) && isset($_POST['pw']) && isset($_POST['pwvf'])){
        $key = $_POST['key'];
	      $pw = $_POST['pw'];
	      $pwvf = $_POST['pwvf'];
        $result = $auth->resetPass($key,$pw,$pwvf);
	echo "<script>alert(\"".$result['message']."\")</script>";
        if(!$result['error']){
            echo "<script type='text/javascript'>window.location = './index.php';</script>";
        }
    }
    ?>
    <div class="container">
      <div class="row margin-bottom-50"></div>
      <div class="row margin-bottom-50">
         <form action="reset.php" method="post" class="form-signin" style="max-width: 50%; width: 50%;">
          <h2 class="margin-bottom-30"><?php echo $MSG_CHANGE_PASSWORD;?></h2>
	        <label for="inputId"><?php echo $MSG_KEY?></label>
	        <input type="text" name="key" class="form-control margin-bottom-20" required autofocus>
          <label for="inputPassword"><?php echo $MSG_NEW_PASSWORD?></label>
          <input type="password" name="pw" class="form-control margin-bottom-20" required>
          <label for="inputPasswordVerify"><?php echo $MSG_NEW_PASSWORD_VERIFY?></label>
          <input type="password" name="pwvf" class="form-control margin-bottom-20" required>
          <button class="btn btn-primary btn-block" type="submit"><?php echo $MSG_CHANGE_SUBMIT;?></button>
        </form>
      </div>
    </div>
    <?php require("importjs.php");?>
    <?php require("footer.php");?>

  </body>
</html>

