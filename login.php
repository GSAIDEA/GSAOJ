<?php
    require_once "include/db_info.php";
    require_once "include/setlang.php";
?>
  <!doctype html>
  <html lang="en">

  <head>

    <title>
      <?php echo $OJ_NAME;?>
    </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php require_once "importcss.php";?>
  </head>

  <body class="body-signin">
    <?php
    require_once "nav.php";
    require_once "include/include_auth.php";
    if ($auth->islogged()) {
        echo "<script>history.back();</script>";
        die();
    }
    if (isset($_POST['id'])) {
        $id=$_POST['id'];
        $password=$_POST['pw'];
        $remember = 0;
        if (isset($_POST['remember'])) {
            $remember = 1;
        }
        $result = $auth->login($id, $password, $remember, null);
        if ($result['error']) {
            echo "<script type='text/javascript'>alert('".$result['message']."');</script>";
        } else {
            echo "<script type='text/javascript'>window.location = \"./index.php\";</script>";
        }
    }
    ?>

      <div class="container">
        <form class="form-signin" action="login.php" method="post">
          <h2 class="margin-bottom-20"><?php echo $MSG_LOGIN_PLZ;?></h2>
          <label for="inputId" class="sr-only"><?php echo $MSG_LOGIN_ID;?></label>
          <input type="text" name="id" class="form-control" placeholder="<?php echo $MSG_LOGIN_ID;?>" required autofocus>
          <label for="inputPassword" class="sr-only"><?php echo $MSG_LOGIN_PW?></label>
          <input type="password" name="pw" class="form-control margin-bottom-10" placeholder="<?php echo $MSG_LOGIN_PW;?>" required>
          <div class="checkbox margin-bottom-20">
            <label>
            <input type="checkbox" value="remember-me" name="remember"><?php echo $MSG_LOGIN_REMEMBERME;?>
          </label>
          </div>
          <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $MSG_LOGIN_SIGNIN;?></button>
        </form>
        <p class="text-center"><a href="./findacc.php">아이디/비밀번호 분실</a></p>
      </div>
      <!-- /container -->

      <?php require_once "importjs.php";?>
      <?php require_once "footer.php";?>

  </body>

  </html>
